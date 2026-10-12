<x-app-layout title="Залы и Роли — Админ-панель">
    <div class="wrap" style="padding-top: 30px;">
        <h2 style="font-family: var(--display); font-weight: 300; font-size: 24px; margin-bottom: 20px;">Администрирование</h2>

        @if(session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; align-items: start;">
            <x-panel title="Добавить событие">
                <form action="{{ route('admin.events.store') }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 12px;">
                        <label style="font-size: 11px; color: var(--dim); text-transform: uppercase;">Площадка</label>
                        <select name="hall_id" style="width: 100%; padding: 8px; background: #0A0A0B; border: 1px solid var(--line); color: #fff; border-radius: 4px;">
                            @foreach($halls as $hall)
                                <option value="{{ $hall->id }}">{{ $hall->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="margin-bottom: 12px;">
                        <label style="font-size: 11px; color: var(--dim); text-transform: uppercase;">Название события</label>
                        <input type="text" name="title" required placeholder="Концерт группы..." style="width: 100%; padding: 8px; background: #0A0A0B; border: 1px solid var(--line); color: #fff; border-radius: 4px;">
                    </div>

                    <div style="margin-bottom: 12px;">
                        <label style="font-size: 11px; color: var(--dim); text-transform: uppercase;">Категория</label>
                        <input type="text" name="category" required placeholder="Концерт / Театр / StandUp" style="width: 100%; padding: 8px; background: #0A0A0B; border: 1px solid var(--line); color: #fff; border-radius: 4px;">
                    </div>

                    <div style="margin-bottom: 12px;">
                        <label style="font-size: 11px; color: var(--dim); text-transform: uppercase;">Дата и время</label>
                        <input type="datetime-local" name="start_at" required style="width: 100%; padding: 8px; background: #0A0A0B; border: 1px solid var(--line); color: #fff; border-radius: 4px;">
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-bottom: 16px;">
                        <div>
                            <label style="font-size: 10px; color: var(--dim);">VIP ₸</label>
                            <input type="number" name="price_vip" value="15000" style="width: 100%; padding: 6px; background: #0A0A0B; border: 1px solid var(--line); color: #fff; border-radius: 4px;">
                        </div>
                        <div>
                            <label style="font-size: 10px; color: var(--dim);">Партер ₸</label>
                            <input type="number" name="price_parter" value="8000" style="width: 100%; padding: 6px; background: #0A0A0B; border: 1px solid var(--line); color: #fff; border-radius: 4px;">
                        </div>
                        <div>
                            <label style="font-size: 10px; color: var(--dim);">Балкон ₸</label>
                            <input type="number" name="price_balcon" value="4500" style="width: 100%; padding: 6px; background: #0A0A0B; border: 1px solid var(--line); color: #fff; border-radius: 4px;">
                        </div>
                    </div>

                    <button type="submit" class="btn gold" style="width: 100%;">Создать мероприятие</button>
                </form>
            </x-panel>

            <x-panel title="Залы и площадки">
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @foreach($halls as $hall)
                        <div style="border: 1px solid var(--line); border-radius: 4px; padding: 12px; background: var(--ink);">
                            <b style="color: var(--gold); font-size: 14px;">{{ $hall->name }}</b>
                            <div style="font-size: 12px; color: var(--mut); margin-top: 4px;">
                                Рядов: {{ $hall->total_rows }} · Мест в ряду: {{ $hall->seats_per_row }} · Всего мест: {{ $hall->total_rows * $hall->seats_per_row }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-panel>
        </div>
    </div>
</x-app-layout>