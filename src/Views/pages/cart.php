<meta name="csrf" content="<?= csrfToken() ?>">

<div class="container" style="padding-top:32px;padding-bottom:64px">
    <h1 style="font-size:1.8rem;font-weight:800;margin-bottom:24px">Корзина</h1>

    <?php if (empty($products)): ?>
        <div style="text-align:center;padding:64px 0">
            <div style="font-size:4rem;margin-bottom:16px">🛒</div>
            <h2 style="margin-bottom:8px">Корзина пуста</h2>
            <p style="color:var(--muted);margin-bottom:24px">Добавьте товары из каталога</p>
            <a href="/catalog" class="btn btn--primary">Перейти в каталог</a>
        </div>
    <?php else: ?>
        <div style="display:grid;grid-template-columns:1fr 320px;gap:32px;align-items:start">

            <!-- Список товаров -->
            <div>
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Товар</th>
                            <th>Цена</th>
                            <th>Кол-во</th>
                            <th>Сумма</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $p): ?>
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:12px">
                                        <div style="width:56px;height:56px;background:var(--green-light);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.8rem;flex-shrink:0">🧴</div>
                                        <div>
                                            <a href="/catalog/<?= e($p['slug']) ?>" style="font-weight:600;color:var(--text);text-decoration:none;font-size:.9rem"><?= e($p['name']) ?></a>
                                            <p style="font-size:.8rem;color:var(--muted);margin-top:2px"><?= e($p['volume']) ?> <?= e($p['unit']) ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-weight:600;white-space:nowrap"><?= formatPrice($p['price']) ?></td>
                                <td>
                                    <form method="POST" action="/cart/update" style="display:inline">
                                        <input type="hidden" name="_csrf" value="<?= csrfToken() ?>">
                                        <input type="hidden" name="id" value="<?= e($p['id']) ?>">
                                        <div style="display:flex;align-items:center;border:1.5px solid var(--border);border-radius:8px;overflow:hidden;width:fit-content">
                                            <button type="submit" name="qty" value="<?= $p['qty'] - 1 ?>" class="qty-btn">−</button>
                                            <span style="width:36px;text-align:center;font-size:.95rem"><?= $p['qty'] ?></span>
                                            <button type="submit" name="qty" value="<?= $p['qty'] + 1 ?>" class="qty-btn">+</button>
                                        </div>
                                    </form>
                                </td>
                                <td style="font-weight:700;color:var(--green-dark);white-space:nowrap"><?= formatPrice($p['price'] * $p['qty']) ?></td>
                                <td>
                                    <form method="POST" action="/cart/remove">
                                        <input type="hidden" name="_csrf" value="<?= csrfToken() ?>">
                                        <input type="hidden" name="id" value="<?= e($p['id']) ?>">
                                        <button type="submit" style="background:none;border:none;cursor:pointer;color:var(--muted);font-size:1.1rem" title="Удалить">✕</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>

            <!-- Итого -->
            <div class="cart-summary" style="position:sticky;top:84px">
                <h3 style="font-size:1rem;font-weight:700;margin-bottom:16px">Итого</h3>
                <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:.9rem">
                    <span style="color:var(--muted)">Товары (<?= count($products) ?>)</span>
                    <span><?= formatPrice($total) ?></span>
                </div>
                <div style="border-top:2px solid var(--border);margin:16px 0;padding-top:16px;display:flex;justify-content:space-between;font-size:1.15rem;font-weight:800">
                    <span>К оплате</span>
                    <span style="color:var(--green-dark)"><?= formatPrice($total) ?></span>
                </div>
                <a href="/order" class="btn btn--primary btn--full">Оформить заказ</a>
                <a href="/catalog" class="btn btn--outline btn--full" style="margin-top:8px">Продолжить покупки</a>
            </div>

        </div>
    <?php endif ?>
</div>

<style>
.qty-btn { background:none;border:none;width:32px;height:32px;font-size:1rem;cursor:pointer;color:var(--text); }
.qty-btn:hover { background:var(--bg-soft); }
@media(max-width:768px) { div[style*="grid-template-columns:1fr 320px"] { grid-template-columns:1fr; } }
</style>
