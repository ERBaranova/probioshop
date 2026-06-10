<div style="display:grid;grid-template-columns:1fr 300px;gap:24px;align-items:start">

    <!-- Детали заказа -->
    <div>
        <div class="admin-card" style="margin-bottom:16px">
            <div class="admin-card-header">
                <h2>Заказ <code><?= e($order['id']) ?></code></h2>
                <span class="status-badge status-<?= e($order['status']) ?>"><?= Order::statusLabel($order['status']) ?></span>
            </div>
            <div style="padding:20px;display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div>
                    <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;color:var(--muted);margin-bottom:4px">Клиент</div>
                    <div style="font-weight:600"><?= e($order['name']) ?></div>
                    <div style="font-size:.875rem;color:var(--muted)"><?= e($order['phone']) ?></div>
                    <div style="font-size:.875rem;color:var(--muted)"><?= e($order['email']) ?></div>
                </div>
                <div>
                    <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;color:var(--muted);margin-bottom:4px">Тип / Компания</div>
                    <div><?= $order['client_type'] === 'business' ? '💼 Юридическое лицо' : '🏠 Физическое лицо' ?></div>
                    <?php if (!empty($order['company'])): ?>
                        <div style="font-size:.875rem;color:var(--muted)"><?= e($order['company']) ?></div>
                    <?php endif ?>
                </div>
                <div>
                    <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;color:var(--muted);margin-bottom:4px">Адрес</div>
                    <div style="font-size:.875rem"><?= e($order['address'] ?: '—') ?></div>
                </div>
                <div>
                    <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;color:var(--muted);margin-bottom:4px">Дата заказа</div>
                    <div style="font-size:.875rem"><?= e($order['created_at']) ?></div>
                </div>
                <?php if (!empty($order['comment'])): ?>
                    <div style="grid-column:1/-1">
                        <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;color:var(--muted);margin-bottom:4px">Комментарий</div>
                        <div style="font-size:.875rem;background:#fafafa;border-radius:8px;padding:10px"><?= e($order['comment']) ?></div>
                    </div>
                <?php endif ?>
            </div>
        </div>

        <!-- Состав заказа -->
        <div class="admin-card">
            <div class="admin-card-header"><h2>Состав заказа</h2></div>
            <table>
                <thead><tr><th>Товар</th><th>Цена</th><th>Кол-во</th><th>Сумма</th></tr></thead>
                <tbody>
                    <?php foreach ($order['items'] as $item): ?>
                        <tr>
                            <td style="font-weight:500"><?= e($item['name']) ?></td>
                            <td><?= number_format($item['price'], 0, ',', ' ') ?> ₽</td>
                            <td><?= $item['qty'] ?></td>
                            <td style="font-weight:700"><?= number_format($item['price'] * $item['qty'], 0, ',', ' ') ?> ₽</td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align:right;font-weight:700;color:var(--muted)">Итого:</td>
                        <td style="font-weight:800;font-size:1.1rem;color:#1a5235"><?= number_format($order['total'], 0, ',', ' ') ?> ₽</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Смена статуса -->
    <div>
        <div class="admin-card">
            <div class="admin-card-header"><h2>Сменить статус</h2></div>
            <div style="padding:16px;display:flex;flex-direction:column;gap:8px">
                <?php
                $allStatuses = ['new'=>'Новый','processing'=>'В обработке','shipped'=>'Отправлен','done'=>'Выполнен','cancelled'=>'Отменён'];
                foreach ($allStatuses as $s => $label):
                    $isCurrent = $order['status'] === $s;
                ?>
                    <form method="POST" action="/admin/orders/<?= e($order['id']) ?>/status">
                        <input type="hidden" name="_csrf" value="<?= csrfToken() ?>">
                        <input type="hidden" name="status" value="<?= $s ?>">
                        <button type="submit" class="btn btn-sm <?= $isCurrent ? 'btn-primary' : 'btn-outline' ?>"
                                style="width:100%;justify-content:flex-start" <?= $isCurrent ? 'disabled' : '' ?>>
                            <span class="status-badge status-<?= $s ?>" style="font-size:.65rem"><?= $label ?></span>
                            <?= $isCurrent ? '← текущий' : '' ?>
                        </button>
                    </form>
                <?php endforeach ?>
            </div>
        </div>

        <a href="/admin/orders" class="btn btn-outline btn-sm" style="margin-top:12px;width:100%">← Все заказы</a>
    </div>

</div>
