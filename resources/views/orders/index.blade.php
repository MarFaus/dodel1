@extends('layouts.app')

@section('content')
<section style="padding-block: 40px 20px;">
    <h1 style="font-family: var(--display); font-size: 32px; font-weight: 200; margin: 0 0 16px;">📦 Мои заказы</h1>

    <x-alert type="info" message="Все созданные заказы сохраняются. Отмена заказа освобождает места на схеме зала." />

    <div id="ordersContainer" style="margin-top: 24px;"></div>
</section>
@endsection

@push('scripts')
<script>
    function renderOrdersPage() {
        const container = document.getElementById('ordersContainer');
        let orders = JSON.parse(localStorage.getItem('my_orders') || '[]');
        container.innerHTML = '';

        if (orders.length === 0) {
            container.innerHTML = `
                <div style="text-align: center; padding: 48px; background: var(--surface); border: 1px solid var(--line); border-radius: 8px; color: var(--mut);">
                    <p style="font-size: 16px; margin-bottom: 12px;">У вас пока нет активных заказов</p>
                    <a href="/events" style="color: var(--gold); font-weight: 600;">Перейти к афише и выбрать места →</a>
                </div>
            `;
            return;
        }

        orders.forEach(ord => {
            const isPaid = ord.status === 'paid' || ord.status === 'Оплачен';
            const isPending = ord.status === 'pending' || ord.status === 'Ожидает оплаты';

            const statusColor = isPaid ? '#6FB98B' : (isPending ? '#D2A14B' : '#C8584C');
            const statusBg = isPaid ? 'rgba(111,185,139,.08)' : (isPending ? 'rgba(210,161,75,.08)' : 'rgba(200,88,76,.08)');
            const statusBorder = isPaid ? 'rgba(111,185,139,.4)' : (isPending ? 'rgba(210,161,75,.4)' : 'rgba(200,88,76,.4)');

            const priceNum = Number(ord.price || 0).toLocaleString() + ' ₸';

            let actionBtns = '';
            if (isPending) {
                actionBtns = `
                    <button onclick="payOrder('${ord.orderNumber}')" style="background: var(--gold); color: #17120A; border: none; padding: 8px 16px; border-radius: 4px; font-weight: 600; font-size: 13px; cursor: pointer;">💳 Оплатить</button>
                    <button onclick="cancelOrder('${ord.orderNumber}')" style="background: transparent; color: var(--bad); border: 1px solid rgba(200,88,76,.4); padding: 8px 16px; border-radius: 4px; font-size: 13px; cursor: pointer;">❌ Отменить</button>
                `;
            } else if (isPaid) {
                actionBtns = `
                    <button onclick="downloadTicket('${ord.orderNumber}')" style="background: rgba(111,185,139,.15); color: var(--ok); border: 1px solid rgba(111,185,139,.4); padding: 8px 16px; border-radius: 4px; font-size: 13px; cursor: pointer;">📥 Скачать PDF-билет</button>
                `;
            }

            const card = document.createElement('div');
            card.id = 'order-card-' + ord.orderNumber;
            card.style.cssText = 'background: var(--surface); border: 1px solid var(--line); border-radius: 8px; padding: 20px; margin-bottom: 16px;';

            card.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <span style="font-family: var(--display); font-size: 15px; color: var(--fg);">Заказ №${ord.orderNumber}</span>
                    <span style="font-size: 11px; letter-spacing: .1em; text-transform: uppercase; padding: 4px 10px; border-radius: 999px; border: 1px solid ${statusBorder}; color: ${statusColor}; background:${statusBg};">
                        ${ord.status}
                    </span>
                </div>

                <div style="font-size: 14px; color: var(--mut); margin-bottom: 8px;">
                    <strong style="color: var(--fg);">${ord.eventName}</strong>
                </div>

                <div style="font-size: 13px; color: var(--dim); margin-bottom: 12px;">
                    Выбранные места: <span style="color: var(--fg);">${ord.seatsInfo || 'Места не указаны'}</span>
                </div>

                <div style="font-family: var(--display); font-size: 18px; color: var(--gold); margin-bottom: 16px;">
                    ${priceNum}
                </div>

                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    ${actionBtns}
                    <button onclick="deleteOrder('${ord.orderNumber}')" style="background: transparent; color: var(--dim); border: 1px solid var(--line); padding: 8px 16px; border-radius: 4px; font-size: 13px; margin-left: auto; cursor: pointer;">🗑 Удалить заказ</button>
                </div>
            `;

            container.appendChild(card);
        });
    }

    function releaseSeats(eventId, keys) {
        if (!eventId || !keys) return;
        const occupied = JSON.parse(localStorage.getItem('occupied_event_' + eventId) || '[]');
        const updated = occupied.filter(k => !keys.includes(k));
        localStorage.setItem('occupied_event_' + eventId, JSON.stringify(updated));
    }

    function payOrder(num) {
        let orders = JSON.parse(localStorage.getItem('my_orders') || '[]');
        const ord = orders.find(o => String(o.orderNumber) === String(num));
        if (ord) {
            ord.status = 'Оплачен';
            localStorage.setItem('my_orders', JSON.stringify(orders));
            renderOrdersPage();
            showToast('✅ Заказ №' + num + ' успешно оплачен!');
        }
    }

    function cancelOrder(num) {
        if (!confirm('Отменить заказ №' + num + '?')) return;
        let orders = JSON.parse(localStorage.getItem('my_orders') || '[]');
        const ord = orders.find(o => String(o.orderNumber) === String(num));
        if (ord) {
            ord.status = 'Отменён';
            releaseSeats(ord.eventId, ord.seatKeys);
            localStorage.setItem('my_orders', JSON.stringify(orders));
            renderOrdersPage();
            showToast('❌ Заказ отменён. Места освобождены!');
        }
    }

    function deleteOrder(num) {
        if (!confirm('Полностью удалить заказ №' + num + '?')) return;
        let orders = JSON.parse(localStorage.getItem('my_orders') || '[]');
        const ord = orders.find(o => String(o.orderNumber) === String(num));
        if (ord) {
            if (ord.status !== 'Отменён') releaseSeats(ord.eventId, ord.seatKeys);
            orders = orders.filter(o => String(o.orderNumber) !== String(num));
            localStorage.setItem('my_orders', JSON.stringify(orders));
            renderOrdersPage();
            showToast('🗑 Заказ №' + num + ' удалён.');
        }
    }

    function downloadTicket(num) {
        showToast('📄 Загрузка PDF-билета для заказа №' + num + '...');
    }

    document.addEventListener('DOMContentLoaded', renderOrdersPage);
</script>
@endpush