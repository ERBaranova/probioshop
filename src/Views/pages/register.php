<div class="form-card" style="max-width:520px">
    <h1>Регистрация</h1>
    <?php if ($error): ?>
        <div class="alert alert--error"><?= e($error) ?></div>
    <?php endif ?>
    <form method="POST" action="/register">
        <input type="hidden" name="_csrf" value="<?= csrfToken() ?>">

        <!-- Тип аккаунта -->
        <div class="form-group">
            <label class="form-label">Тип аккаунта</label>
            <div style="display:flex;gap:10px">
                <label style="flex:1;cursor:pointer;display:flex;align-items:center;gap:8px;border:1.5px solid var(--border);border-radius:8px;padding:10px 14px;font-size:.9rem">
                    <input type="radio" name="client_type" value="private" checked> 🏠 Для дома
                </label>
                <label style="flex:1;cursor:pointer;display:flex;align-items:center;gap:8px;border:1.5px solid var(--border);border-radius:8px;padding:10px 14px;font-size:.9rem">
                    <input type="radio" name="client_type" value="business"> 💼 Для бизнеса
                </label>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Имя *</label>
                <input type="text" name="name" class="form-input" required placeholder="Иван">
            </div>
            <div class="form-group">
                <label class="form-label">Телефон</label>
                <input type="tel" name="phone" class="form-input" placeholder="+7 (999) 000-00-00">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-input" required placeholder="mail@example.com">
        </div>
        <div class="form-group">
            <label class="form-label">Пароль *</label>
            <input type="password" name="password" class="form-input" required placeholder="Минимум 6 символов" minlength="6">
        </div>

        <button type="submit" class="btn btn--primary btn--full" style="margin-top:8px">Создать аккаунт</button>
    </form>
    <p style="text-align:center;margin-top:20px;font-size:.9rem;color:var(--muted)">
        Уже есть аккаунт? <a href="/login" style="color:var(--green)">Войти</a>
    </p>
</div>
<style>.form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}@media(max-width:480px){.form-row{grid-template-columns:1fr}}</style>
