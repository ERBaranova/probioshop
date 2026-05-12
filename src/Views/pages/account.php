<div class="container">
    <div class="account-layout">
        <?php include SRC . '/Views/components/account_nav.php'; ?>
        <div class="account-main">
            <h2>Добро пожаловать, <?= e($user['name']) ?>!</h2>
            <p style="color:var(--muted);margin-bottom:24px">
                <?= $user['client_type'] === 'business' ? '💼 Бизнес-аккаунт' : '🏠 Личный аккаунт' ?>
                · <?= e($user['email']) ?>
            </p>

            <?php if (!empty($orders)): ?>
                <h3 style="font-size:.95rem;font-weight:700;margin-bottom:12px;color:var(--muted);text-transform:uppercase;letter-spacing:.05em">Последние заказы</h3>
                <?php foreach ($orders as $order): ?>
                    <div class="order-row">
                        <div>
                            <div style="font-weight:700;font-size:.9rem;font-family:monospace"><?= e($order['id']) ?></div>
                            <div style="font-size:.8rem;color:var(--muted)"><?= e($order['created_at']) ?></div>
                        </div>
                        <span class="status-badge status-<?= e($order['status']) ?>"><?= Order::statusLabel($order['status']) ?></span>
                        <span style="font-weight:700"><?= formatPrice($order['total']) ?></span>
                    </div>
                <?php endforeach ?>
                <a href="/account/orders" style="font-size:.85rem;color:var(--green);text-decoration:none;display:block;margin-top:12px">Все заказы →</a>
            <?php else: ?>
                <div style="text-align:center;padding:40px 0;color:var(--muted)">
                    <div style="font-size:3rem;margin-bottom:12px">📦</div>
                    <p>У вас ещё нет заказов</p>
                    <a href="/catalog" class="btn btn--primary" style="margin-top:16px">Перейти в каталог</a>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>
