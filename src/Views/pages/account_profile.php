<div class="container">
    <div class="account-layout">
        <?php include SRC . '/Views/components/account_nav.php'; ?>
        <div class="account-main">
            <h2>Мои данные</h2>
            <?php if ($ok): ?><div class="alert alert--success"><?= e($ok) ?></div><?php endif ?>
            <?php if ($error): ?><div class="alert alert--error"><?= e($error) ?></div><?php endif ?>

            <form method="POST" action="/account/profile">
                <input type="hidden" name="_csrf" value="<?= csrfToken() ?>">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Имя</label>
                        <input type="text" name="name" class="form-input" value="<?= e($user['name']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Телефон</label>
                        <input type="tel" name="phone" class="form-input" value="<?= e($user['phone'] ?? '') ?>" placeholder="+7 (999) 000-00-00">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" value="<?= e($user['email']) ?>" disabled style="opacity:.6">
                    <p style="font-size:.75rem;color:var(--muted);margin-top:4px">Email изменить нельзя</p>
                </div>
                <div class="form-group">
                    <label class="form-label">Адрес доставки</label>
                    <input type="text" name="address" class="form-input" value="<?= e($user['address'] ?? '') ?>" placeholder="Город, улица, дом">
                </div>
                <?php if ($user['client_type'] === 'business'): ?>
                    <div class="form-group">
                        <label class="form-label">Компания</label>
                        <input type="text" name="company" class="form-input" value="<?= e($user['company'] ?? '') ?>" placeholder="ООО «Название»">
                    </div>
                <?php endif ?>
                <button type="submit" class="btn btn--primary">Сохранить</button>
            </form>
        </div>
    </div>
</div>
<style>.form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}@media(max-width:600px){.form-row{grid-template-columns:1fr}}</style>
