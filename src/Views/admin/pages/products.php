<?php if (!empty($ok)): ?><div class="alert alert-success"><?= e($ok) ?></div><?php endif ?>

<div class="admin-card">
    <div class="admin-card-header">
        <h2>Товары (<?= count($products) ?>)</h2>
        <a href="/admin/products/create" class="btn btn-primary btn-sm">+ Добавить товар</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Товар</th>
                <th>Категория</th>
                <th>Цена</th>
                <th>Аудитория</th>
                <th>Наличие</th>
                <th>Рейтинг</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $p): ?>
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            <div style="width:40px;height:40px;background:#e8f5ee;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0">🧴</div>
                            <div>
                                <div style="font-weight:600;font-size:.875rem"><?= e($p['name']) ?></div>
                                <div style="font-size:.75rem;color:var(--muted)"><?= e($p['brand'] ?? 'Chrisal') ?> · <?= e($p['volume']) ?> <?= e($p['unit']) ?></div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:.8rem;color:var(--muted)"><?= e($p['category']) ?></td>
                    <td>
                        <div style="font-weight:700"><?= number_format($p['price'], 0, ',', ' ') ?> ₽</div>
                        <?php if (!empty($p['price_old']) && $p['price_old'] > $p['price']): ?>
                            <div style="font-size:.75rem;color:var(--muted);text-decoration:line-through"><?= number_format($p['price_old'], 0, ',', ' ') ?> ₽</div>
                        <?php endif ?>
                    </td>
                    <td style="font-size:.8rem">
                        <?php if (in_array('private', $p['audience'] ?? [])): ?><span style="margin-right:4px">🏠</span><?php endif ?>
                        <?php if (in_array('business', $p['audience'] ?? [])): ?><span>💼</span><?php endif ?>
                    </td>
                    <td>
                        <label class="toggle" title="Переключить наличие">
                            <input type="checkbox" <?= $p['in_stock'] ? 'checked' : '' ?>
                                   data-product-id="<?= e($p['id']) ?>"
                                   onchange="toggleStock(this, '<?= e($p['id']) ?>')">
                            <span class="toggle-slider"></span>
                        </label>
                    </td>
                    <td style="font-size:.8rem">
                        <?php if ($p['rating'] ?? 0): ?>
                            <span style="color:#f59e0b">★</span> <?= number_format($p['rating'], 1) ?>
                            <span style="color:var(--muted)">(<?= $p['reviews_count'] ?>)</span>
                        <?php else: ?>
                            <span style="color:var(--muted)">—</span>
                        <?php endif ?>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px">
                            <a href="/catalog/<?= e($p['slug']) ?>" target="_blank" class="btn btn-ghost btn-sm" title="Просмотр">👁</a>
                            <a href="/admin/products/<?= e($p['id']) ?>/edit" class="btn btn-ghost btn-sm" title="Редактировать">✏️</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<script>
const csrf = '<?= csrfToken() ?>';
async function toggleStock(checkbox, id) {
    try {
        const res  = await fetch('/admin/products/' + id + '/toggle', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: '_csrf=' + encodeURIComponent(csrf),
        });
        const data = await res.json();
        if (!data.ok) checkbox.checked = !checkbox.checked;
    } catch { checkbox.checked = !checkbox.checked; }
}
</script>
