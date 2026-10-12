@extends('layouts.app')

@section('content')
<section style="padding-block: 40px 20px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
        <div>
            <span style="font-size: 11px; letter-spacing: .16em; text-transform: uppercase; color: var(--dim);">Афиша Костаная</span>
            <h1 style="font-family: var(--display); font-size: 32px; font-weight: 200; margin: 8px 0 0;">Мероприятия и билеты</h1>
        </div>
    </div>

    <x-alert type="info" message="Интерактивная 3D-сцена, подсвечивание рядов и управление масштабированием (Zoom/Pan) активны!" />

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; margin-top: 24px;">
        <x-event-card id="1" title="Қара Жорға. Симфония" category="Концерт" date="24 октября 2026, 19:00" hall="Большой зал филармонии" :price="11000" />
        <x-event-card id="2" title="Ромео и Джульетта" category="Театр" date="26 октября 2026, 18:30" hall="Драмтеатр им. Горького" :price="8500" />
        <x-event-card id="3" title="Jazz Night Quartet" category="Классика" date="07 ноября 2026, 20:00" hall="Большой зал филармонии" :price="9000" />
        <x-event-card id="4" title="Ледовое шоу «Зимняя сказка»" category="Семья" date="14 ноября 2026, 17:00" hall="Ледовая арена «Көктем»" :price="7500" />
    </div>
</section>

<!-- Модальное окно зала с 3D-сценой и Zoom/Pinch -->
<div id="hallModal" style="position: fixed; inset: 0; background: rgba(10,10,11,.92); backdrop-filter: blur(16px); display: none; justify-content: center; align-items: center; z-index: 1000; padding: 20px;">
    <div style="background: var(--surface); border: 1px solid var(--line-2); border-radius: 12px; width: 100%; max-width: 820px; max-height: 92vh; overflow-y: auto; padding: 28px; position: relative;">
        
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
            <div>
                <h2 id="modalTitle" style="font-family: var(--display); font-size: 20px; font-weight: 300; margin: 0; color: var(--fg);">Выбор мест</h2>
                <span id="modalSub" style="font-size: 13px; color: var(--mut);"></span>
            </div>
            <button onclick="closeHallModal()" style="font-size: 22px; color: var(--mut);">✕</button>
        </div>

        <!-- 3D Сцена с наклоном -->
        <div style="perspective: 500px; text-align: center; margin-bottom: 24px;">
            <div style="height: 32px; background: linear-gradient(180deg, var(--gold) 0%, rgba(198,163,104,0.08) 100%); transform: rotateX(-28deg); border-radius: 50% 50% 0 0 / 100% 100% 0 0; box-shadow: 0 10px 25px rgba(198,163,104,0.3); border-top: 1px solid var(--gold);"></div>
            <span style="font-size: 10.5px; letter-spacing: .3em; text-transform: uppercase; color: var(--dim);">ЭКРАН / СЦЕНА (3D PROJECTION)</span>
        </div>

        <!-- Панель Zoom / Pan -->
        <div style="display: flex; gap: 8px; justify-content: flex-end; margin-bottom: 12px;">
            <button onclick="adjustZoom(0.1)" style="border: 1px solid var(--line); border-radius: 4px; padding: 4px 10px; color: var(--gold);">🔍 +</button>
            <button onclick="adjustZoom(-0.1)" style="border: 1px solid var(--line); border-radius: 4px; padding: 4px 10px; color: var(--gold);">🔍 -</button>
            <button onclick="resetZoom()" style="border: 1px solid var(--line); border-radius: 4px; padding: 4px 10px; color: var(--mut);">Сброс</button>
        </div>

        <!-- Зал с Zoom и Drag -->
        <div id="hallContainer" style="overflow: auto; border: 1px solid var(--line); border-radius: 8px; padding: 24px; background: var(--ink); text-align: center; cursor: grab;">
            <div id="zoomableHall" style="transform-origin: center top; transition: transform 0.15s ease-out; display: inline-block;">
                <div id="seatsGrid" style="display: flex; flex-direction: column; gap: 8px; align-items: center;"></div>
            </div>
        </div>

        <!-- Итог и Оформление -->
        <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div>
                <span style="font-size: 12px; color: var(--dim); display: block;">Выбранные места (макс. 6):</span>
                <strong id="selectedSeatsList" style="color: var(--fg); font-size: 14px;">Не выбрано</strong>
            </div>
            <div style="text-align: right;">
                <span style="font-size: 12px; color: var(--dim); display: block;">Итоговая сумма:</span>
                <strong id="totalPrice" style="font-family: var(--display); font-size: 22px; color: var(--gold);">0 ₸</strong>
            </div>
            <button id="bookBtn" disabled onclick="submitBooking()" style="background: var(--gold); color: #17120A; border: none; padding: 12px 28px; border-radius: 4px; font-weight: 600; cursor: not-allowed; opacity: 0.4;">
                Забронировать
            </button>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentEv = null;
    let selectedSeats = [];
    let zoomScale = 1.0;

    function adjustZoom(delta) {
        zoomScale = Math.min(Math.max(0.7, zoomScale + delta), 1.5);
        document.getElementById('zoomableHall').style.transform = `scale(${zoomScale})`;
    }

    function resetZoom() {
        zoomScale = 1.0;
        document.getElementById('zoomableHall').style.transform = 'scale(1)';
    }

    function openHallPicker(id, title, date, price) {
        currentEv = { id, title, date, price };
        selectedSeats = [];
        zoomScale = 1.0;
        resetZoom();

        document.getElementById('modalTitle').textContent = title;
        document.getElementById('modalSub').textContent = `${date} •${price.toLocaleString()} ₸ / место`;

        renderSeats(id);
        updateSummary();

        document.getElementById('hallModal').style.display = 'flex';
    }

    function closeHallModal() {
        document.getElementById('hallModal').style.display = 'none';
    }

    function getOccupiedSeats(eventId) {
        const stored = localStorage.getItem('occupied_event_' + eventId);
        return stored ? JSON.parse(stored) : ['R1S3', 'R2S4', 'R2S5'];
    }

    function renderSeats(eventId) {
        const grid = document.getElementById('seatsGrid');
        grid.innerHTML = '';
        const occupied = getOccupiedSeats(eventId);

        for (let r = 1; r <= 6; r++) {
            const rowDiv = document.createElement('div');
            rowDiv.style.cssText = 'display: flex; gap: 8px; align-items: center;';

            const rLabel = document.createElement('span');
            rLabel.style.cssText = 'width: 48px; font-size: 11px; color: var(--dim); text-align: right; font-weight: 600;';
            rLabel.textContent = 'Ряд ' + r;
            rowDiv.appendChild(rLabel);

            for (let s = 1; s <= 10; s++) {
                const key = `R${r}S${s}`;
                const isOccupied = occupied.includes(key);

                const seatBtn = document.createElement('button');
                seatBtn.style.cssText = `
                    width: 28px; height: 28px; border-radius: 4px; font-size: 10px; font-weight: 600;
                    display: flex; align-items: center; justify-content: center; transition: all 0.15s;
                    border: 1px solid ${isOccupied ? 'transparent' : 'var(--line-2)'};
                    background: ${isOccupied ? 'rgba(255,255,255,0.06)' : 'transparent'};
                    color: ${isOccupied ? 'transparent' : 'var(--fg)'};
                    cursor: ${isOccupied ? 'not-allowed' : 'pointer'};
                `;
                seatBtn.textContent = s;

                if (!isOccupied) {
                    seatBtn.onclick = () => toggleSeat(key, r, s, seatBtn);
                }

                rowDiv.appendChild(seatBtn);
            }
            grid.appendChild(rowDiv);
        }
    }

    function toggleSeat(key, r, s, btn) {
        const idx = selectedSeats.findIndex(x => x.key === key);
        if (idx > -1) {
            selectedSeats.splice(idx, 1);
            btn.style.background = 'transparent';
            btn.style.color = 'var(--fg)';
            btn.style.borderColor = 'var(--line-2)';
        } else {
            if (selectedSeats.length >= 6) {
                showToast('В одном заказе разрешено не более 6 мест');
                return;
            }
            selectedSeats.push({ key, row: r, seat: s });
            btn.style.background = 'var(--gold)';
            btn.style.color = '#17120A';
            btn.style.borderColor = 'var(--gold)';
        }
        updateSummary();
    }

    function updateSummary() {
        const listText = document.getElementById('selectedSeatsList');
        const priceText = document.getElementById('totalPrice');
        const btn = document.getElementById('bookBtn');

        if (selectedSeats.length === 0) {
            listText.textContent = 'Не выбрано';
            priceText.textContent = '0 ₸';
            btn.disabled = true;
            btn.style.opacity = '0.4';
            btn.style.cursor = 'not-allowed';
        } else {
            listText.textContent = selectedSeats.map(s => `Р${s.row}М${s.seat}`).join(', ');
            const total = selectedSeats.length * currentEv.price;
            priceText.textContent = total.toLocaleString() + ' ₸';

            btn.disabled = false;
            btn.style.opacity = '1';
            btn.style.cursor = 'pointer';
        }
    }

    function submitBooking() {
        const occupied = getOccupiedSeats(currentEv.id);
        const newKeys = selectedSeats.map(s => s.key);
        localStorage.setItem('occupied_event_' + currentEv.id, JSON.stringify([...occupied, ...newKeys]));

        const seatDescr = selectedSeats.map(s => `Ряд ${s.row} (место ${s.seat})`).join(', ');
        const orderNum = Math.floor(1000 + Math.random() * 9000).toString();

        const newOrder = {
            orderNumber: orderNum,
            eventId: currentEv.id,
            eventName: currentEv.title,
            price: selectedSeats.length * currentEv.price,
            status: 'Ожидает оплаты',
            seatsInfo: seatDescr,
            seatKeys: newKeys
        };

        const existing = JSON.parse(localStorage.getItem('my_orders') || '[]');
        existing.unshift(newOrder);
        localStorage.setItem('my_orders', JSON.stringify(existing));

        closeHallModal();
        showToast('🎉 Заказ №' + orderNum + ' сформирован! Перейдите в "Мои заказы".');
    }
</script>
@endpush