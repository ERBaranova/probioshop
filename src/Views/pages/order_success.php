<div class="container" style="padding:80px 20px;text-align:center;max-width:520px;margin:0 auto">
    <div style="width:80px;height:80px;background:var(--green-light);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:2.5rem;margin:0 auto 24px">✓</div>
    <h1 style="font-size:1.8rem;font-weight:800;margin-bottom:12px;color:var(--green-dark)">Заявка отправлена!</h1>
    <?php if ($orderId): ?>
        <p style="color:var(--muted);margin-bottom:8px">Номер вашей заявки:</p>
        <p style="font-size:1.2rem;font-weight:700;font-family:monospace;margin-bottom:24px"><?= e($orderId) ?></p>
    <?php endif ?>
    <p style="color:var(--muted);margin-bottom:32px;line-height:1.7">
        Наш менеджер свяжется с вами в течение рабочего дня для подтверждения заказа и уточнения деталей доставки.
    </p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
        <?php if (isLoggedIn()): ?>
            <a href="/account/orders" class="btn btn--primary">Мои заказы</a>
        <?php endif ?>
        <a href="/catalog" class="btn btn--outline">Продолжить покупки</a>
    </div>
</div>
