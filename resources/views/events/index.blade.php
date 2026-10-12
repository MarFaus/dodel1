<x-app-layout title="Афиша мероприятий — Билетный Портал">
    <div class="wrap" style="padding-top: 30px;">
        <x-panel title="Афиша · Октябрь — Ноябрь 2026">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1 style="font-family: var(--display); font-weight: 200; font-size: 28px; margin-top: 4px;">Выбор мест на интерактивной схеме</h1>
                    <p style="color: var(--mut); font-size: 13.5px; margin: 6px 0 0;">Выберите любое мероприятие, чтобы открыть 3D-схему зала и забронировать билеты.</p>
                </div>
            </div>
        </x-panel>

        @if(session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif
        @if(session('warning'))
            <x-alert type="warning" :message="session('warning')" />
        @endif

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px; margin-top: 20px;">
            @foreach($events as $event)
                <x-event-card
                    :id="$event->id"
                    :title="$event->title"
                    :date="$event->start_at->format('d.m.Y H:i')"
                    :category="$event->category"
                    :hall="$event->hall->name"
                    :price="$event->prices['balcon'] ?? $event->prices['parter'] ?? 5000"
                    :status="$event->status"
                />
            @endforeach
        </div>
    </div>
</x-app-layout>