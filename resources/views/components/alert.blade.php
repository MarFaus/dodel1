@props(['type' => 'info', 'message' => ''])
@php
    $borderColor = match($type) {
        'success' => 'rgba(111,185,139,.4)',
        'warning' => 'rgba(210,161,75,.4)',
        'error'   => 'rgba(200,88,76,.4)',
        default   => 'rgba(198,163,104,.38)'
    };
    $textColor = match($type) {
        'success' => '#6FB98B',
        'warning' => '#D2A14B',
        'error'   => '#C8584C',
        default   => '#C6A368'
    };
@endphp
<div style="background: var(--surface); border: 1px solid {{ $borderColor }}; border-left: 4px solid {{ $textColor }}; border-radius: 6px; padding: 14px 18px; margin-block: 16px; color: {{ $textColor }}; font-size: 13.5px;">
    <strong>{{ strtoupper($type) }}:</strong> {{ $message }}
</div>