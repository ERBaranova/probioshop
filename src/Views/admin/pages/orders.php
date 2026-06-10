<!-- Фильтры по статусу -->
<div style="display:flex;gap:8px;margin-bottom:20px;flex-wrap:wrap">
    <?php
    $statuses = ['' => 'Все', 'new' => 'Новые', 'processing' => 'В обработке', 'shipped' => 'Отправлен', 'done' => 'Выполнен', 'cancelled' => 'Отменён'];
    foreach ($statuses as $s => $label):
    ?>
        <a href="/admin/orders<?= $s ? '?status=' . $s : '' ?>"
           class="btn btn-sm <?= $filterStatus === $s ? 'btn-primary' : 'btn-outline' ?>">
            <?= $label ?>
        </a>
    <?php endforeach ?>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h2>Заказы <?= $filterStatus ? '· ' . Order::statusLabel($filterStatus) : '' ?> (<?= count($orders) ?>)</h2>
    </div>
    <?php if (empty($orders)): ?>
        <div style="padding:32px;text-align:center;color:var(--muted)">Заказов нет</div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>№ заказа</th>
                    <th>Клиент</th>
                    <th>Тип</th>
                    <th>Товары</th>
                    <th>Сумма</th>
                    <th>Статус</th>
                    <th>Дата</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $o): ?>
                    <tr>
                        <td><code style="font-size:.75rem"><?= e($o['id']) ?></code></td>
                        <td>
                            <div style="font-weight:600;font-size:.875rem"><?= e($o['name']) ?></div>
                            <div style="font-size:.75rem;color:var(--muted)"><?= e($o['phone']) ?></div>
                        </td>
                        <td>
                            <?= $o['client_type'] === 'business'
                                ? '<span style="font-size:.75rem;background:#ede9fe;color:#5b21b6;padding:2px 7px;border-radius:4px;font-weight:700">Бизнес</span>'
                                : '<span style="font-size:.75rem;background:#f3f4f6;color:var(--muted);padding:2px 7px;border-radius:4px">Физлицо</span>' ?>
                        </td>
                        <td style="color:var(--muted);font-size:.8rem"><?= count($o['items']) ?> поз.</td>
                        <td style="font-weight:700;white-space:nowrap"><?= number_format($o['total'], 0, ',', ' ') ?> ₽</td>
                        <td><span class="status-badge status-<?= e($o['status']) ?>"><?= Order::statusLabel($o['status']) ?></span></td>
                        <td style="color:var(--muted);font-size:.8rem;white-space:nowrap"><?= e(substr($o['created_at'], 0, 10)) ?></td>
                        <td><a href="/admin/orders/<?= e($o['id']) ?>" class="btn btn-ghost btn-sm">→</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
</div>
