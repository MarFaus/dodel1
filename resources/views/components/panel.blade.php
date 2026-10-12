@props([
    'title' => null
])

<div style="border: 1px solid rgba(255,255,255,0.085); border-radius: 6px; background: #0E0E10; overflow: hidden; margin-bottom: 20px;">
    @if($title)
        <div style="padding: 14px 18px; border-bottom: 1px solid rgba(255,255,255,0.085); font-family: 'Unbounded', sans-serif; font-size: 14px; color: #EFEDE8;">
            {{ $title }}
        </div>
    @endif
    <div style="padding: 18px;">
        {{ $slot }}
    </div>
</div>