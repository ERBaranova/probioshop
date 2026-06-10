<div class="admin-card">
    <div class="admin-card-header">
        <h2>Пользователи (<?= count($users) ?>)</h2>
    </div>
    <?php if (empty($users)): ?>
        <div style="padding:32px;text-align:center;color:var(--muted)">
            Зарегистрированных пользователей ещё нет
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Пользователь</th>
                    <th>Тип</th>
                    <th>Телефон</th>
                    <th>Заказов</th>
                    <th>Зарегистрирован</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td>
                            <div style="font-weight:600"><?= e($u['name']) ?></div>
                            <div style="font-size:.78rem;color:var(--muted)"><?= e($u['email']) ?></div>
                            <?php if (!empty($u['company'])): ?>
                                <div style="font-size:.75rem;color:var(--muted)"><?= e($u['company']) ?></div>
                            <?php endif ?>
                        </td>
                        <td>
                            <?= $u['client_type'] === 'business'
                                ? '<span style="font-size:.75rem;background:#ede9fe;color:#5b21b6;padding:2px 7px;border-radius:4px;font-weight:700">Бизнес</span>'
                                : '<span style="font-size:.75rem;background:#f3f4f6;color:var(--muted);padding:2px 7px;border-radius:4px">Физлицо</span>' ?>
                        </td>
                        <td style="font-size:.875rem;color:var(--muted)"><?= e($u['phone'] ?: '—') ?></td>
                        <td>
                            <?php $cnt = $ordersByUser[$u['id']] ?? 0; ?>
                            <?php if ($cnt > 0): ?>
                                <a href="/admin/orders" style="font-weight:700;color:var(--accent)"><?= $cnt ?></a>
                            <?php else: ?>
                                <span style="color:var(--muted)">0</span>
                            <?php endif ?>
                        </td>
                        <td style="font-size:.8rem;color:var(--muted)"><?= e(substr($u['created_at'], 0, 10)) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
</div>
