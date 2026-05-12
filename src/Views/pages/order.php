<meta name="csrf" content="<?= csrfToken() ?>">

<div class="container" style="padding-top:32px;padding-bottom:64px">
    <h1 style="font-size:1.8rem;font-weight:800;margin-bottom:24px">Оформление заказа</h1>

    <div style="display:grid;grid-template-columns:1fr 340px;gap:32px;align-items:start">

        <form method="POST" action="/order/place">
            <input type="hidden" name="_csrf" value="<?= csrfToken() ?>">

            <!-- Тип клиента -->
            <div style="background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:24px;margin-bottom:20px">
                <h3 style="font-size:1rem;font-weight:700;margin-bottom:16px">Тип покупателя</h3>
                <div style="display:flex;gap:12px">
                    <label style="flex:1;cursor:pointer">
                        <input type="radio" name="client_type" value="private" checked style="display:none" class="client-radio">
                        <div class="client-type-btn client-type-btn--active" data-for="private">🏠 Физическое лицо</div>
                    </label>
                    <label style="flex:1;cursor:pointer">
                        <input type="radio" name="client_type" value="business" style="display:none" class="client-radio">
                        <div class="client-type-btn" data-for="business">💼 Юридическое лицо</div>
                    </label>
                </div>
            </div>

            <!-- Контактные данные -->
            <div style="background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:24px;margin-bottom:20px">
                <h3 style="font-size:1rem;font-weight:700;margin-bottom:16px">Контактные данные</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Имя *</label>
                        <input type="text" name="name" class="form-input" required
                               value="<?= e($user['name'] ?? '') ?>" placeholder="Иван Иванов">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Телефон *</label>
                        <input type="tel" name="phone" class="form-input" required
                               value="<?= e($user['phone'] ?? '') ?>" placeholder="+7 (999) 000-00-00">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-input" required
                           value="<?= e($user['email'] ?? '') ?>" placeholder="mail@example.com">
                </div>
                <!-- Для юрлица -->
                <div id="business-fields" style="display:none">
                    <div class="form-group">
                        <label class="form-label">Название компании</label>
                        <input type="text" name="company" class="form-input"
                               value="<?= e($user['company'] ?? '') ?>" placeholder="ООО «Название»">
                    </div>
                </div>
            </div>

            <!-- Адрес -->
            <div style="background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:24px;margin-bottom:20px">
                <h3 style="font-size:1rem;font-weight:700;margin-bottom:16px">Адрес доставки</h3>
                <div class="form-group">
                    <label class="form-label">Адрес</label>
                    <input type="text" name="address" class="form-input"
                           value="<?= e($user['address'] ?? '') ?>"
                           placeholder="Город, улица, дом, квартира">
                </div>
                <div class="form-group">
                    <label class="form-label">Комментарий к заказу</label>
                    <textarea name="comment" class="form-input" rows="3"
                              placeholder="Время доставки, особые пожелания..."></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn--primary" style="padding:14px 32px;font-size:1rem">
                Отправить заявку →
            </button>
            <p style="color:var(--muted);font-size:.8rem;margin-top:10px">
                Наш менеджер свяжется с вами для подтверждения заказа
            </p>
        </form>

        <!-- Сводка заказа -->
        <div style="position:sticky;top:84px">
            <div style="background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:24px">
                <h3 style="font-size:1rem;font-weight:700;margin-bottom:16px">Ваш заказ</h3>
                <?php foreach ($items as $item): ?>
                    <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:12px;gap:8px">
                        <span style="font-size:.9rem;flex:1"><?= e($item['name']) ?> × <?= $item['qty'] ?></span>
                        <span style="font-size:.9rem;font-weight:600;white-space:nowrap"><?= formatPrice($item['price'] * $item['qty']) ?></span>
                    </div>
                <?php endforeach ?>
                <div style="border-top:2px solid var(--border);margin-top:16px;padding-top:16px;display:flex;justify-content:space-between;font-size:1.1rem;font-weight:800">
                    <span>Итого</span>
                    <span style="color:var(--green-dark)"><?= formatPrice($total) ?></span>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
.client-type-btn { border:2px solid var(--border); border-radius:var(--radius); padding:12px 16px; text-align:center; font-size:.9rem; font-weight:600; transition:all .2s; }
.client-type-btn--active { border-color:var(--green); background:var(--green-light); color:var(--green-dark); }
.form-row { display:grid;grid-template-columns:1fr 1fr;gap:16px; }
textarea.form-input { resize:vertical; }
@media(max-width:768px) { div[style*="grid-template-columns:1fr 340px"] { grid-template-columns:1fr; } .form-row { grid-template-columns:1fr; } }
</style>
<script>
document.querySelectorAll('.client-radio').forEach(radio => {
    radio.addEventListener('change', () => {
        document.querySelectorAll('.client-type-btn').forEach(b => b.classList.remove('client-type-btn--active'));
        radio.nextElementSibling.classList.add('client-type-btn--active');
        document.getElementById('business-fields').style.display = radio.value === 'business' ? 'block' : 'none';
    });
});
</script>
