<!-- Статистика -->
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-card__label">Новых заказов</div>
        <div class="stat-card__value danger"><?= $stats['orders_new'] ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-card__label">Всего заказов</div>
        <div class="stat-card__value"><?= $stats['orders_total'] ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-card__label">Товаров</div>
        <div class="stat-card__value"><?= $stats['products_total'] ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-card__label">Пользователей</div>
        <div class="stat-card__value"><?= $stats['users_total'] ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-card__label">Выручка (выполнено)</div>
        <div class="stat-card__value accent"><?= number_format($stats['revenue'], 0, ',', ' ') ?> ₽</div>
    </div>
</div>

<!-- Статусы заказов -->
<?php if (!empty($byStatus)): ?>
<div style="display:flex;gap:10px;margin-bottom:24px;flex-wrap:wrap">
    <?php
    $statusColors = ['new'=>'#dbeafe','processing'=>'#fef3c7','shipped'=>'#ede9fe','done'=>'#d1fae5','cancelled'=>'#fee2e2'];
    foreach ($byStatus as $s => $cnt):
    ?>
        <a href="/admin/orders?status=<?= $s ?>" style="background:<?= $statusColors[$s] ?? '#f3f4f6' ?>;border-radius:8px;padding:10px 16px;text-decoration:none;color:var(--text)">
            <div style="font-size:1.3rem;font-weight:800"><?= $cnt ?></div>
            <div style="font-size:.75rem;color:var(--muted);margin-top:2px"><?= Order::statusLabel($s) ?></div>
        </a>
    <?php endforeach ?>
</div>
<?php endif ?>

<!-- Последние заказы -->
<div class="admin-card">
    <div class="admin-card-header">
        <h2>Последние заказы</h2>
        <a href="/admin/orders" class="btn btn-outline btn-sm">Все заказы</a>
    </div>
    <?php if (empty($recentOrders)): ?>
        <div style="padding:24px;text-align:center;color:var(--muted)">Заказов ещё нет</div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>№ заказа</th>
                    <th>Клиент</th>
                    <th>Сумма</th>
                    <th>Статус</th>
                    <th>Дата</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentOrders as $o): ?>
                    <tr>
                        <td><code><?= e($o['id']) ?></code></td>
                        <td>
                            <div style="font-weight:600"><?= e($o['name']) ?></div>
                            <div style="font-size:.78rem;color:var(--muted)"><?= e($o['phone']) ?></div>
                        </td>
                        <td style="font-weight:700"><?= number_format($o['total'], 0, ',', ' ') ?> ₽</td>
                        <td><span class="status-badge status-<?= e($o['status']) ?>"><?= Order::statusLabel($o['status']) ?></span></td>
                        <td style="color:var(--muted);white-space:nowrap"><?= e(substr($o['created_at'], 0, 10)) ?></td>
                        <td><a href="/admin/orders/<?= e($o['id']) ?>" class="btn btn-ghost btn-sm">→</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
</div>
