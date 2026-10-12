<x-app-layout title="{{ $event->title }} — Выбор мест">
    <div class="wrap" style="padding-top: 20px;">
        <a href="{{ route('events.index') }}" style="color: var(--mut); text-decoration: none; font-size: 13px;">← Афиша</a>
        
        <div style="display: grid; grid-template-columns: 1fr 340px; gap: 30px; margin-top: 20px;">
            <div>
                <h1 style="font-family: var(--display); font-size: 28px; font-weight: 300;">{{ $event->title }}</h1>
                <p style="color: var(--mut); font-size: 14px; margin-bottom: 20px;">{{ $event->description }}</p>

                <div class="hall">
                    <div class="stage"><div class="stage-bar"></div><span>Сцена</span></div>
                    
                    <div style="display: flex; flex-direction: column; gap: 8px; align-items: center;" id="seat-map">
                        @for($r = 1; $r <= $hall->total_rows; $r++)
                            @php
                                $rowSeats = $seatsByRow->get($r) ?? collect();
                            @endphp
                            <div style="display: flex; gap: 6px; align-items: center;">
                                <span style="font-size: 11px; color: var(--dim); width: 20px; text-align: center;">{{ $r }}</span>
                                @foreach($rowSeats as$seat)
                                    @php
                                        $isOccupied = in_array($seat->id,$occupiedSeatIds);
                                    @endphp
                                    <button 
                                        type="button" 
                                        class="seat {{ $seat->zone === 'vip' ? 'vip' : '' }} {{$isOccupied ? 'taken' : '' }}"
                                        data-seat-id="{{ $seat->id }}"
                                        data-row="{{ $seat->row_number }}"
                                        data-seat="{{ $seat->seat_number }}"
                                        data-price="{{ $event->prices[$seat->zone] ?? 5000 }}"
                                        {{ $isOccupied ? 'disabled' : '' }}
                                    >
                                        {{ $seat->seat_number }}
                                    </button>
                                @endforeach
                                <span style="font-size: 11px; color: var(--dim); width: 20px; text-align: center;">{{ $r }}</span>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            <div>
                <x-panel title="Оформление заказа">
                    <form id="order-form">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                        
                        <div style="margin-bottom: 12px;">
                            <label style="font-size: 11px; color: var(--dim); text-transform: uppercase;">ФИО</label>
                            <input type="text" name="customer_name" required placeholder="Иван Иванов" style="width: 100%; padding: 8px; background: #0A0A0B; border: 1px solid var(--line); color: #fff; border-radius: 4px;">
                        </div>

                        <div style="margin-bottom: 12px;">
                            <label style="font-size: 11px; color: var(--dim); text-transform: uppercase;">E-mail</label>
                            <input type="email" name="customer_email" required placeholder="user@mail.kz" style="width: 100%; padding: 8px; background: #0A0A0B; border: 1px solid var(--line); color: #fff; border-radius: 4px;">
                        </div>

                        <div style="margin-bottom: 12px;">
                            <label style="font-size: 11px; color: var(--dim); text-transform: uppercase;">Телефон</label>
                            <input type="tel" name="customer_phone" required placeholder="+7 777 000 0000" style="width: 100%; padding: 8px; background: #0A0A0B; border: 1px solid var(--line); color: #fff; border-radius: 4px;">
                        </div>

                        <div style="margin-bottom: 16px;">
                            <label style="font-size: 11px; color: var(--dim); text-transform: uppercase;">Способ оплаты</label>
                            <select name="payment_method" style="width: 100%; padding: 8px; background: #0A0A0B; border: 1px solid var(--line); color: #fff; border-radius: 4px;">
                                <option value="kaspi">Kaspi Pay</option>
                                <option value="cloud">CloudPayments</option>
                                <option value="stripe">Stripe</option>
                            </select>
                        </div>

                        <div id="selected-seats-info" style="font-size: 13px; color: var(--mut); margin-bottom: 12px;">
                            Выберите места на схеме
                        </div>

                        <button type="submit" class="btn gold" style="width: 100%;" id="submit-btn" disabled>
                            Оплатить <span id="total-price">0</span> ₸
                        </button>
                    </form>
                </x-panel>
            </div>
        </div>
    </div>

    <script>
        const selectedSeats = new Map();

        document.querySelectorAll('.seat:not(.taken)').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.seatId;
                if (selectedSeats.has(id)) {
                    selectedSeats.delete(id);
                    btn.classList.remove('sel');
                } else {
                    if (selectedSeats.size >= 6) return alert('Не более 6 мест!');
                    selectedSeats.set(id, {
                        row: btn.dataset.row,
                        seat: btn.dataset.seat,
                        price: parseInt(btn.dataset.price)
                    });
                    btn.classList.add('sel');
                }
                updateForm();
            });
        });

        function updateForm() {
            const info = document.getElementById('selected-seats-info');
            const totalEl = document.getElementById('total-price');
            const submitBtn = document.getElementById('submit-btn');

            if (selectedSeats.size === 0) {
                info.innerText = 'Выберите места на схеме';
                totalEl.innerText = '0';
                submitBtn.disabled = true;
                return;
            }

            let total = 0;
            let text = [];
            selectedSeats.forEach((val) => {
                total += val.price;
                text.push(`Ряд ${val.row} м.${val.seat}`);
            });

            info.innerText = text.join(', ');
            totalEl.innerText = total.toLocaleString();
            submitBtn.disabled = false;
        }

        document.getElementById('order-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            selectedSeats.forEach((_, key) => formData.append('seat_ids[]', key));

            const res = await fetch('/orders', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await res.json();
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                alert(data.message || 'Ошибка бронирования');
            }
        });
    </script>
</x-app-layout>