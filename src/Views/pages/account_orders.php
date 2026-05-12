<div class="container">
    <div class="account-layout">
        <?php include SRC . '/Views/components/account_nav.php'; ?>
        <div class="account-main">
            <h2>Мои заказы</h2>
            <?php if (empty($orders)): ?>
                <div style="text-align:center;padding:40px 0;color:var(--muted)">
                    <div style="font-size:3rem;margin-bottom:12px">📦</div>
                    <p>Заказов пока нет</p>
                    <a href="/catalog" class="btn btn--primary" style="margin-top:16px">Перейти в каталог</a>
                </div>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                    <div style="border:1px solid var(--border);border-radius:var(--radius);margin-bottom:16px;overflow:hidden">
                        <div style="background:var(--bg-soft);padding:14px 18px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px">
                            <div>
                                <span style="font-weight:700;font-family:monospace;font-size:.9rem"><?= e($order['id']) ?></span>
                                <span style="color:var(--muted);font-size:.8rem;margin-left:12px"><?= e($order['created_at']) ?></span>
                            </div>
                            <div style="display:flex;align-items:center;gap:12px">
                                <span class="status-badge status-<?= e($order['status']) ?>"><?= Order::statusLabel($order['status']) ?></span>
                                <span style="font-weight:700"><?= formatPrice($order['total']) ?></span>
                            </div>
                        </div>
                        <div style="padding:14px 18px">
                            <?php foreach ($order['items'] as $item): ?>
                                <div style="display:flex;justify-content:space-between;font-size:.9rem;padding:4px 0">
                                    <span><?= e($item['name']) ?> × <?= $item['qty'] ?></span>
                                    <span style="color:var(--muted)"><?= formatPrice($item['price'] * $item['qty']) ?></span>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
</div>
