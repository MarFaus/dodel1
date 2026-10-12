<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title ?? 'Билетный Портал — Костанай'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@400;500;600&family=Unbounded:wght@200;300;400&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        :root {
            --ink: #0A0A0B; --surface: #0E0E10; --surface-2: #141417; --raise: #1A1A1E;
            --line: rgba(255,255,255,.085); --line-2: rgba(255,255,255,.16);
            --fg: #EFEDE8; --mut: #8B8B91; --dim: #5E5E64;
            --gold: #C6A368; --gold-dim: rgba(198,163,104,.13); --gold-line: rgba(198,163,104,.38);
            --ok: #6FB98B; --warn: #D2A14B; --bad: #C8584C;
            --display: 'Unbounded', sans-serif;
            --body: 'Golos Text', sans-serif;
            color-scheme: dark;
        }
        * { box-sizing: border-box; }
        body { background: var(--ink); color: var(--fg); font-family: var(--body); font-size: 15px; margin: 0; line-height: 1.55; }
        h1,h2,h3,h4 { margin: 0; font-weight: 500; letter-spacing: -.02em; }
        a { color: inherit; text-decoration: none; }
        .wrap { max-width: 1180px; margin: 0 auto; padding-inline: 20px; }
        
        .top { position: sticky; top: 0; z-index: 40; background: rgba(10,10,11,.86); backdrop-filter: blur(14px); border-bottom: 1px solid var(--line); }
        .top-in { display: flex; align-items: center; gap: 22px; height: 62px; }
        .brand { display: flex; align-items: baseline; gap: 9px; font-family: var(--display); font-weight: 300; font-size: 15px; letter-spacing: .2em; text-transform: uppercase; }
        .brand i { width: 7px; height: 7px; border: 1px solid var(--gold); border-radius: 50%; display: inline-block; transform: translateY(-1px); }
        .nav { display: flex; gap: 4px; margin-left: 8px; }
        .nav a { padding: 7px 13px; border-radius: 999px; color: var(--mut); font-size: 13.5px; transition: .18s; }
        .nav a:hover, .nav a.active { color: var(--fg); background: var(--surface-2); }
        .top-right { margin-left: auto; display: flex; align-items: center; gap: 12px; }
        .city { font-size: 13px; color: var(--mut); }

        .btn { display: inline-block; text-align: center; padding: 10px 18px; border-radius: 4px; font-weight: 500; font-size: 13.5px; transition: .18s; border: none; cursor: pointer; }
        .btn.gold { background: var(--gold); color: #17120A; }
        .btn.gold:hover { background: #D7B57B; }
        .btn.ghost { background: none; border: 1px solid var(--line-2); color: var(--mut); }
        .btn.ghost:hover { color: var(--fg); border-color: var(--fg); }

        .hall { border: 1px solid var(--line); border-radius: 6px; background: var(--surface); padding: 26px 20px 22px; }
        .stage { text-align: center; margin-bottom: 24px; }
        .stage-bar { height: 3px; border-radius: 999px; background: linear-gradient(90deg, transparent, var(--gold-line) 18%, var(--gold) 50%, var(--gold-line) 82%, transparent); margin-bottom: 10px; }
        .stage span { font-size: 10.5px; letter-spacing: .3em; text-transform: uppercase; color: var(--dim); }

        .seat { width: 23px; height: 23px; border-radius: 3.5px; border: 1px solid var(--line-2); background: transparent; font-size: 9.5px; color: var(--dim); transition: .14s; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .seat:hover:not(:disabled) { border-color: var(--gold); color: var(--gold); transform: translateY(-1px); }
        .seat.vip { border-color: var(--gold-line); }
        .seat.taken { background: rgba(255,255,255,.055); border-color: transparent; color: transparent; cursor: not-allowed; }
        .seat.sel { background: var(--gold); border-color: var(--gold); color: #17120A; font-weight: 600; }

        .foot { padding-block: 34px 48px; color: var(--dim); font-size: 12px; display: flex; justify-content: space-between; gap: 16px; flex-wrap: wrap; border-top: 1px solid var(--line); margin-top: 50px; }
    </style>
</head>
<body>

<header class="top">
    <div class="wrap top-in">
        <a href="<?php echo e(route('events.index')); ?>" class="brand"><i></i>Билетный Портал</a>
        <nav class="nav">
            <a href="<?php echo e(route('events.index')); ?>" class="<?php echo e(request()->routeIs('events*') ? 'active' : ''); ?>">Афиша</a>
            <a href="<?php echo e(route('orders.index')); ?>" class="<?php echo e(request()->routeIs('orders*') ? 'active' : ''); ?>">Мои заказы</a>
            <a href="<?php echo e(route('analytics.index')); ?>" class="<?php echo e(request()->routeIs('analytics*') ? 'active' : ''); ?>">Аналитика</a>
            <a href="<?php echo e(route('admin.index')); ?>" class="<?php echo e(request()->routeIs('admin*') ? 'active' : ''); ?>">Залы и роли</a>
            <a href="<?php echo e(route('scan.index')); ?>" class="<?php echo e(request()->routeIs('scan*') ? 'active' : ''); ?>">Контроль</a>
        </nav>
        <div class="top-right">
            <span class="city">Костанай</span>
        </div>
    </div>
</header>

<main>
    <?php echo e($slot); ?>

</main>

<div class="wrap">
    <footer class="foot">
        <span>Билетный Портал · Laravel 11 · Костанай</span>
        <span>Blade Components · PostgreSQL · Redis · DomPDF</span>
    </footer>
</div>

</body>
</html><?php /**PATH C:\Dodelivanie\sait_kards_pm03\resources\views/components/app-layout.blade.php ENDPATH**/ ?>