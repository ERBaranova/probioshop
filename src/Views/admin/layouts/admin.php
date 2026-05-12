<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Админ — ' . APP_NAME) ?></title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --sidebar: #1a1f2e;
            --sidebar-hover: #252b3b;
            --sidebar-active: #2d7a4f;
            --accent: #2d7a4f;
            --accent-light: #e8f5ee;
            --text: #1a1a1a;
            --muted: #6b7280;
            --border: #e5e7eb;
            --bg: #f3f4f6;
            --white: #ffffff;
            --radius: 10px;
            --danger: #ef4444;
            --warning-bg: #fef3c7;
            --warning-text: #92400e;
        }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: var(--bg); color: var(--text); display: flex; min-height: 100vh; }

        /* SIDEBAR */
        .sidebar { width: 220px; background: var(--sidebar); display: flex; flex-direction: column; flex-shrink: 0; }
        .sidebar-logo { padding: 20px 18px; border-bottom: 1px solid rgba(255,255,255,.08); }
        .sidebar-logo a { color: #fff; text-decoration: none; font-weight: 800; font-size: 1rem; display: flex; align-items: center; gap: 8px; }
        .sidebar-label { padding: 18px 18px 6px; font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; color: rgba(255,255,255,.3); }
        .sidebar-nav a { display: flex; align-items: center; gap: 10px; padding: 10px 18px; color: rgba(255,255,255,.7); text-decoration: none; font-size: .875rem; transition: all .15s; }
        .sidebar-nav a:hover { background: var(--sidebar-hover); color: #fff; }
        .sidebar-nav a.active { background: var(--sidebar-active); color: #fff; font-weight: 600; }
        .sidebar-nav a .badge-new { background: #ef4444; color: #fff; font-size: .65rem; font-weight: 700; padding: 1px 6px; border-radius: 10px; margin-left: auto; }
        .sidebar-footer { margin-top: auto; padding: 16px 18px; border-top: 1px solid rgba(255,255,255,.08); }
        .sidebar-footer a { color: rgba(255,255,255,.5); font-size: .8rem; text-decoration: none; }
        .sidebar-footer a:hover { color: #fff; }

        /* MAIN */
        .admin-main { flex: 1; display: flex; flex-direction: column; min-width: 0; }
        .admin-topbar { background: var(--white); border-bottom: 1px solid var(--border); padding: 0 28px; height: 56px; display: flex; align-items: center; justify-content: space-between; }
        .admin-topbar h1 { font-size: 1rem; font-weight: 700; }
        .admin-topbar-right { display: flex; align-items: center; gap: 16px; font-size: .85rem; color: var(--muted); }
        .admin-content { padding: 28px; flex: 1; }

        /* CARDS */
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 28px; }
        .stat-card { background: var(--white); border-radius: var(--radius); padding: 20px; border: 1px solid var(--border); }
        .stat-card__label { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: var(--muted); margin-bottom: 8px; }
        .stat-card__value { font-size: 1.8rem; font-weight: 800; color: var(--text); }
        .stat-card__value.accent { color: var(--accent); }
        .stat-card__value.danger { color: var(--danger); }

        /* TABLE */
        .admin-card { background: var(--white); border-radius: var(--radius); border: 1px solid var(--border); overflow: hidden; margin-bottom: 20px; }
        .admin-card-header { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
        .admin-card-header h2 { font-size: .95rem; font-weight: 700; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 10px 16px; font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: var(--muted); border-bottom: 1px solid var(--border); background: #fafafa; white-space: nowrap; }
        td { padding: 12px 16px; border-bottom: 1px solid var(--border); font-size: .875rem; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fafafa; }

        /* STATUS BADGES */
        .status-badge { display: inline-block; font-size: .72rem; font-weight: 700; padding: 3px 8px; border-radius: 5px; white-space: nowrap; }
        .status-new        { background: #dbeafe; color: #1e40af; }
        .status-processing { background: #fef3c7; color: #92400e; }
        .status-shipped    { background: #ede9fe; color: #5b21b6; }
        .status-done       { background: #d1fae5; color: #065f46; }
        .status-cancelled  { background: #fee2e2; color: #991b1b; }

        /* BTNS */
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 8px 16px; border-radius: 8px; font-size: .85rem; font-weight: 600; cursor: pointer; border: none; text-decoration: none; transition: all .15s; }
        .btn-primary { background: var(--accent); color: #fff; }
        .btn-primary:hover { background: #1a5235; }
        .btn-outline { background: transparent; color: var(--accent); border: 1.5px solid var(--accent); }
        .btn-outline:hover { background: var(--accent-light); }
        .btn-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .btn-danger:hover { background: #fecaca; }
        .btn-sm { padding: 5px 10px; font-size: .78rem; }
        .btn-ghost { background: none; border: none; color: var(--muted); cursor: pointer; padding: 4px 8px; border-radius: 6px; font-size: .8rem; }
        .btn-ghost:hover { background: var(--bg); color: var(--text); }

        /* FORMS */
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: .8rem; font-weight: 600; margin-bottom: 5px; color: var(--text); }
        .form-input { width: 100%; padding: 9px 12px; border: 1.5px solid var(--border); border-radius: 8px; font-size: .875rem; transition: border-color .15s; background: #fff; }
        .form-input:focus { outline: none; border-color: var(--accent); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }

        /* MISC */
        .alert { padding: 10px 14px; border-radius: 8px; font-size: .875rem; margin-bottom: 16px; }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-error   { background: #fee2e2; color: #991b1b; }
        .toggle { position: relative; width: 36px; height: 20px; }
        .toggle input { opacity: 0; width: 0; height: 0; }
        .toggle-slider { position: absolute; inset: 0; background: #d1d5db; border-radius: 20px; cursor: pointer; transition: .2s; }
        .toggle-slider::before { content: ''; position: absolute; width: 14px; height: 14px; left: 3px; top: 3px; background: white; border-radius: 50%; transition: .2s; }
        .toggle input:checked + .toggle-slider { background: var(--accent); }
        .toggle input:checked + .toggle-slider::before { transform: translateX(16px); }
        a { color: var(--accent); }
        code { background: #f3f4f6; padding: 1px 5px; border-radius: 4px; font-size: .8rem; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <a href="/admin">🧬 <?= APP_NAME ?> <span style="font-size:.7rem;opacity:.5;font-weight:400">admin</span></a>
    </div>

    <div class="sidebar-label">Главное</div>
    <nav class="sidebar-nav">
        <?php
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $newCount = count(array_filter((new Order())->all(), fn($o) => $o['status'] === 'new'));
        ?>
        <a href="/admin"          class="<?= $path === '/admin' ? 'active' : '' ?>">📊 Дашборд</a>
        <a href="/admin/orders"   class="<?= str_starts_with($path, '/admin/orders') ? 'active' : '' ?>">
            📦 Заказы
            <?php if ($newCount > 0): ?><span class="badge-new"><?= $newCount ?></span><?php endif ?>
        </a>
        <a href="/admin/products" class="<?= str_starts_with($path, '/admin/products') ? 'active' : '' ?>">🧴 Товары</a>
        <a href="/admin/b2b"     class="<?= str_starts_with($path, '/admin/b2b') ? 'active' : '' ?>">💼 B2B заявки</a>
        <a href="/admin/b2b"     class="<?= str_starts_with($path, '/admin/b2b') ? 'active' : '' ?>">💼 B2B заявки</a>
        <a href="/admin/users"    class="<?= str_starts_with($path, '/admin/users') ? 'active' : '' ?>">👤 Пользователи</a>
    </nav>

    <div class="sidebar-label">Магазин</div>
    <nav class="sidebar-nav">
        <a href="/" target="_blank">🌐 Открыть сайт</a>
    </nav>

    <div class="sidebar-footer">
        <a href="/admin/logout">← Выйти</a>
    </div>
</aside>

<div class="admin-main">
    <div class="admin-topbar">
        <h1><?= e($title ?? 'Админ') ?></h1>
        <div class="admin-topbar-right">
            <span>👤 <?= e($_SESSION[SESSION_ADMIN_KEY]['login'] ?? 'admin') ?></span>
        </div>
    </div>
    <div class="admin-content">
        <?= $content ?>
    </div>
</div>

</body>
</html>
