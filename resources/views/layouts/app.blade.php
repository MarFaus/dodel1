<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Билетный Портал</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Unbounded:wght@200;300;400;500&family=Golos+Text:wght@400;500;600;700&display=swap">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        :root {
            --ink: #0A0A0B;
            --surface: #0E0E10;
            --surface-2: #141417;
            --raise: #1A1A1E;
            --line: rgba(255,255,255,.085);
            --line-2: rgba(255,255,255,.16);
            --fg: #EFEDE8;
            --mut: #8B8B91;
            --dim: #5E5E64;
            --gold: #C6A368;
            --gold-dim: rgba(198,163,104,.13);
            --gold-line: rgba(198,163,104,.38);
            --ok: #6FB98B;
            --warn: #D2A14B;
            --bad: #C8584C;
            --display: 'Unbounded', system-ui, sans-serif;
            --body: 'Golos Text', system-ui, sans-serif;
        }
        * { box-sizing: border-box; }
        body {
            background: var(--ink);
            color: var(--fg);
            font-family: var(--body);
            font-size: 15px;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        a { color: inherit; text-decoration: none; }
        button { font: inherit; color: inherit; background: none; border: 0; cursor: pointer; }
        .wrap { max-width: 1180px; margin: 0 auto; padding-inline: 20px; }
        
        .top { position: sticky; top: 0; z-index: 40; background: rgba(10,10,11,.88); backdrop-filter: blur(14px); border-bottom: 1px solid var(--line); }
        .top-in { display: flex; align-items: center; gap: 22px; height: 62px; }
        .brand { display: flex; align-items: center; gap: 9px; font-family: var(--display); font-weight: 300; font-size: 15px; letter-spacing: .2em; text-transform: uppercase; }
        .brand i { width: 8px; height: 8px; border: 1px solid var(--gold); border-radius: 50%; display: inline-block; }
        .nav { display: flex; gap: 4px; margin-left: 12px; }
        .nav a { padding: 7px 14px; border-radius: 999px; color: var(--mut); font-size: 13.5px; transition: .18s; }
        .nav a:hover, .nav a.active { color: var(--ink); background: var(--fg); }
        .nav a[hidden] { display: none !important; }
        .top-right { margin-left: auto; display: flex; align-items: center; gap: 14px; }
        .city { font-size: 13px; color: var(--mut); }
        .role select { background: var(--surface-2); border: 1px solid var(--line); border-radius: 999px; padding: 6px 14px; font-size: 12.5px; color: var(--gold); cursor: pointer; outline: none; }
        
        .foot { padding: 36px 0 48px; color: var(--dim); font-size: 12px; display: flex; justify-content: space-between; border-top: 1px solid var(--line); margin-top: 60px; }
        .toast { position: fixed; left: 50%; bottom: 26px; transform: translateX(-50%) translateY(14px); background: var(--raise); border: 1px solid var(--line-2); border-radius: 999px; padding: 11px 22px; font-size: 13.5px; opacity: 0; pointer-events: none; transition: .25s; z-index: 2000; box-shadow: 0 10px 40px rgba(0,0,0,.6); }
        .toast.on { opacity: 1; transform: translateX(-50%) translateY(0); }
    </style>
</head>
<body>

    <header class="top">
        <div class="wrap top-in">
            <a href="/events" class="brand"><i></i>Билетный Портал</a>
            <nav class="nav">
                <a href="/events" data-roles="customer,manager,admin" class="{{ request()->is('events*') || request()->is('/') ? 'active' : '' }}">Афиша</a>
                <a href="/orders" data-roles="customer,admin" class="{{ request()->is('orders*') ? 'active' : '' }}">Мои заказы</a>
                <a href="/analytics" data-roles="manager,admin" class="{{ request()->is('analytics*') ? 'active' : '' }}">Аналитика</a>
                <a href="/admin" data-roles="manager,admin" class="{{ request()->is('admin*') ? 'active' : '' }}">Залы и роли</a>
                <a href="/scan" data-roles="inspector,admin" class="{{ request()->is('scan*') ? 'active' : '' }}">Контроль</a>
                <a href="/arch" data-roles="customer,manager,admin,inspector" class="{{ request()->is('arch*') ? 'active' : '' }}">Архитектура</a>
            </nav>
            <div class="top-right">
                <span class="city">📍 Костанай</span>
                <div class="role">
                    <select id="roleSelect" onchange="switchRole(this.value)">
                        <option value="customer">Покупатель</option>
                        <option value="manager">Менеджер</option>
                        <option value="admin">Администратор</option>
                        <option value="inspector">Контролёр</option>
                    </select>
                </div>
            </div>
        </div>
    </header>

    <main class="wrap">
        @yield('content')
    </main>

    <footer class="wrap foot">
        <span>Билетный Портал · Костанай 2026</span>
        <span>Laravel 11 · SQLite · RBAC System</span>
    </footer>

    <div id="toast" class="toast"></div>

    <script>
        function showToast(msg) {
            const t = document.getElementById('toast');
            t.textContent = msg;
            t.classList.add('on');
            setTimeout(() => { t.classList.remove('on'); }, 3000);
        }

        function applyRolePermissions() {
            const role = localStorage.getItem('tp_user_role') || 'customer';
            const navLinks = document.querySelectorAll('.nav a[data-roles]');
            
            navLinks.forEach(link => {
                const roles = link.getAttribute('data-roles').split(',');
                if (roles.includes(role)) {
                    link.removeAttribute('hidden');
                } else {
                    link.setAttribute('hidden', 'true');
                }
            });

            const select = document.getElementById('roleSelect');
            if (select) select.value = role;
        }

        function switchRole(role) {
            localStorage.setItem('tp_user_role', role);
            showToast('Роль изменена на: ' + role);
            applyRolePermissions();
            
            // Если текущий раздел недоступен для выбранной роли, перенаправляем
            const currentPath = window.location.pathname;
            if (role === 'inspector' && currentPath !== '/scan' && currentPath !== '/arch') {
                window.location.href = '/scan';
            } else if (role === 'manager' && currentPath === '/orders') {
                window.location.href = '/analytics';
            } else if (role === 'customer' && (currentPath === '/analytics' || currentPath === '/admin' || currentPath === '/scan')) {
                window.location.href = '/events';
            }
        }

        document.addEventListener('DOMContentLoaded', applyRolePermissions);
    </script>
    @stack('scripts')
</body>
</html>