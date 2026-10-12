@props([
    'type' => 'info',
    'message' => ''
])

@php
    $colors = match($type) {
        'success' => 'border-color: rgba(111,185,139,0.45); background: rgba(111,185,139,0.07); color: #6FB98B;',
        'warning' => 'border-color: rgba(210,161,75,0.45); background: rgba(210,161,75,0.07); color: #D2A14B;',
        'error' => 'border-color: rgba(200,88,76,0.45); background: rgba(200,88,76,0.07); color: #C8584C;',
        default => 'border-color: rgba(198,163,104,0.38); background: rgba(198,163,104,0.07); color: #C6A368;'
    };
@endphp

<div style="border-radius: 6px; padding: 14px 18px; border: 1px solid; margin-bottom: 16px; font-size: 13.5px; line-height: 1.5; {{ $colors }}">
    <strong style="text-transform: uppercase; letter-spacing: 0.1em; font-size: 11px; margin-right: 8px;">{{ $type }}:</strong>
    {{ $message ?: $slot }}
</div>