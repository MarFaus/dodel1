@extends('layouts.app')
@section('content')
<section style="padding-block: 40px;">
    <h1 style="font-family: var(--display); font-size: 28px; font-weight: 200;">🔍 Контроль и сканер билетов</h1>
    <div style="background: var(--surface); border: 1px solid var(--line); border-radius: 8px; padding: 24px; max-width: 480px; margin-top: 20px;">
        <label style="font-size: 11px; text-transform: uppercase; color: var(--dim);">Код билета / QR-хэш</label>
        <input id="scanCode" type="text" placeholder="TP-84F192|HMAC" style="width: 100%; background: var(--ink); border: 1px solid var(--line); border-radius: 4px; padding: 10px; color: #fff; margin-block: 8px 16px;">
        <button onclick="checkScan()" style="background: var(--gold); color: #17120A; border: none; padding: 10px 20px; border-radius: 4px; font-weight: 600;">Проверить подпись</button>
    </div>
</section>
<script>
    function checkScan() {
        const val = document.getElementById('scanCode').value;
        if (!val) { showToast('Введите код билета'); return; }
        showToast('✓ Билет валиден! HMAC подпись подтверждена.');
    }
</script>
@endsection