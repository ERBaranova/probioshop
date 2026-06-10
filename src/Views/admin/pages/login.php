<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход — Админ</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: #1a1f2e; display: flex; align-items: center; justify-content: center; min-height: 100vh; font-family: -apple-system, sans-serif; }
        .card { background: #fff; border-radius: 12px; padding: 36px; width: 360px; }
        .logo { text-align: center; font-size: 1.2rem; font-weight: 800; margin-bottom: 24px; color: #1a5235; }
        .form-group { margin-bottom: 14px; }
        .form-label { display: block; font-size: .8rem; font-weight: 600; margin-bottom: 5px; }
        .form-input { width: 100%; padding: 9px 12px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: .9rem; }
        .form-input:focus { outline: none; border-color: #2d7a4f; }
        .btn { width: 100%; padding: 10px; background: #2d7a4f; color: #fff; border: none; border-radius: 8px; font-size: .9rem; font-weight: 700; cursor: pointer; margin-top: 6px; }
        .btn:hover { background: #1a5235; }
        .alert { background: #fee2e2; color: #991b1b; padding: 10px 14px; border-radius: 8px; font-size: .85rem; margin-bottom: 16px; }
    </style>
</head>
<body>
<div class="card">
    <div class="logo">🧬 Probio-Clean · Админ</div>
    <?php if (!empty($error)): ?>
        <div class="alert"><?= htmlspecialchars($error, ENT_QUOTES) ?></div>
    <?php endif ?>
    <form method="POST" action="/admin/login">
        <input type="hidden" name="_csrf" value="<?= csrfToken() ?>">
        <div class="form-group">
            <label class="form-label">Логин</label>
            <input type="text" name="login" class="form-input" autofocus required>
        </div>
        <div class="form-group">
            <label class="form-label">Пароль</label>
            <input type="password" name="password" class="form-input" required>
        </div>
        <button type="submit" class="btn">Войти</button>
    </form>
</div>
</body>
</html>
