<x-app-layout title="Контроль билетов — Билетный Портал">
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <div class="wrap" style="padding-top: 30px;">
        <h2 style="font-family: var(--display); font-weight: 300; font-size: 24px; margin-bottom: 20px;">Контроль на входе</h2>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 26px; align-items: start;">
            <x-panel title="Сканер QR-кода и ручной ввод">
                <div id="reader" style="width: 100%; border-radius: 6px; overflow: hidden; margin-bottom: 16px; background: #0A0A0B;"></div>

                <div style="display: flex; gap: 8px;">
                    <input type="text" id="scan-input" placeholder="TP-XXXXXX|SIGN" style="flex: 1; padding: 10px; background: #0A0A0B; border: 1px solid var(--line); color: #fff; border-radius: 4px; font-size: 13.5px;">
                    <button type="button" id="scan-btn" class="btn gold">Проверить</button>
                </div>
            </x-panel>

            <div>
                <x-panel title="Результат проверки">
                    <div id="scan-result">
                        <div style="color: var(--dim); font-size: 13.5px;">
                            Поднесите QR-код к камере или введите код вручную для авторизации прохода.
                        </div>
                    </div>
                </x-panel>
            </div>
        </div>
    </div>

    <script>
        async function verifyCode(payload) {
            const res = await fetch('{{ route("scan.verify") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ ticket_code: payload })
            });
            const data = await res.json();
            
            const resBox = document.getElementById('scan-result');
            const alertType = data.status === 'ok' ? 'success' : (data.status === 'used' ? 'warning' : 'error');
            
            resBox.innerHTML = `
                <div style="padding: 16px; border-radius: 6px; border: 1px solid ${data.status === 'ok' ? 'rgba(111,185,139,0.45)' : 'rgba(200,88,76,0.45)'}; background: ${data.status === 'ok' ? 'rgba(111,185,139,0.08)' : 'rgba(200,88,76,0.08)'}; color: ${data.status === 'ok' ? 'var(--ok)' : 'var(--bad)'};">
                    <h3 style="margin-bottom: 6px; font-family: var(--display); font-size: 16px;">${data.title}</h3>
                    <p style="margin: 0; font-size: 13.5px; color: var(--fg);">${data.text}</p>
                </div>
            `;
        }

        document.getElementById('scan-btn').addEventListener('click', () => {
            const val = document.getElementById('scan-input').value.trim();
            if (val) verifyCode(val);
        });

        try {
            const html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: {width: 220, height: 220} }, false);
            html5QrcodeScanner.render((decodedText) => {
                document.getElementById('scan-input').value = decodedText;
                verifyCode(decodedText);
            });
        } catch(e) { console.warn('Камера недоступна или отключена'); }
    </script>
</x-app-layout>