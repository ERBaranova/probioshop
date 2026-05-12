<div class="form-card">
    <h1>Войти в аккаунт</h1>
    <?php if ($error): ?>
        <div class="alert alert--error"><?= e($error) ?></div>
    <?php endif ?>
    <form method="POST" action="/login">
        <input type="hidden" name="_csrf" value="<?= csrfToken() ?>">
        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-input" required autofocus placeholder="mail@example.com">
        </div>
        <div class="form-group">
            <label class="form-label">Пароль</label>
            <input type="password" name="password" class="form-input" required placeholder="••••••••">
        </div>
        <button type="submit" class="btn btn--primary btn--full" style="margin-top:8px">Войти</button>
    </form>
    <p style="text-align:center;margin-top:20px;font-size:.9rem;color:var(--muted)">
        Нет аккаунта? <a href="/register" style="color:var(--green)">Зарегистрироваться</a>
    </p>
</div>
