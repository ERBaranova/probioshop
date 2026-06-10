<meta name="csrf" content="<?= csrfToken() ?>">

<div class="container" style="padding-top:32px;padding-bottom:64px">

    <!-- Хлебные крошки -->
    <nav class="breadcrumb">
        <a href="/">Главная</a>
        <span>→</span>
        <a href="/catalog">Каталог</a>
        <span>→</span>
        <span><?= e($product['name']) ?></span>
    </nav>

    <!-- Карточка товара -->
    <div class="product-page">

        <!-- Фото -->
        <div class="product-page__gallery">
            <div class="product-page__img-main">
                <?php if (!empty($product['image']) && file_exists(ROOT . '/public' . $product['image'])): ?>
                    <img src="<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>">
                <?php else: ?>
                    <div style="font-size:8rem;display:flex;align-items:center;justify-content:center;height:100%">🧴</div>
                <?php endif ?>
            </div>
            <?php if (!empty($product['badge'])): ?>
                <span class="product-page__badge"><?= e($product['badge']) ?></span>
            <?php endif ?>
        </div>

        <!-- Информация -->
        <div class="product-page__info">

            <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px">
                <span style="font-size:.85rem;color:var(--muted)"><?= e($product['brand'] ?? 'Chrisal') ?></span>
                <?php if (!empty($product['rating'])): ?>
                    <span style="color:#f59e0b"><?= str_repeat('★', (int)round($product['rating'])) ?></span>
                    <span style="font-size:.85rem;color:var(--muted)"><?= number_format($product['rating'], 1) ?> (<?= $product['reviews_count'] ?> отзыв<?= $product['reviews_count'] === 1 ? '' : ($product['reviews_count'] < 5 ? 'а' : 'ов') ?>)</span>
                <?php endif ?>
            </div>

            <h1 class="product-page__title"><?= e($product['name']) ?></h1>
            <p class="product-page__short-desc"><?= e($product['short_desc']) ?></p>

            <!-- Объём -->
            <div class="product-page__meta">
                <span class="meta-item">📦 <?= e($product['volume']) ?> <?= e($product['unit']) ?></span>
                <?php if (in_array('business', $product['audience'] ?? []) && in_array('private', $product['audience'] ?? [])): ?>
                    <span class="meta-item">🏠 Для дома</span>
                    <span class="meta-item">💼 Для бизнеса</span>
                <?php elseif (in_array('business', $product['audience'] ?? [])): ?>
                    <span class="meta-item">💼 Для бизнеса</span>
                <?php else: ?>
                    <span class="meta-item">🏠 Для дома</span>
                <?php endif ?>
            </div>

            <!-- Цена -->
            <div class="product-page__price-block">
                <span class="product-page__price"><?= formatPrice($product['price']) ?></span>
                <?php if (!empty($product['price_old']) && $product['price_old'] > $product['price']): ?>
                    <span class="product-page__price-old"><?= formatPrice($product['price_old']) ?></span>
                    <?php
                        $discount = round((1 - $product['price'] / $product['price_old']) * 100);
                    ?>
                    <span class="discount-badge">−<?= $discount ?>%</span>
                <?php endif ?>
            </div>

            <!-- В корзину -->
            <?php if ($product['in_stock']): ?>
                <div class="product-page__cart">
                    <div class="qty-control">
                        <button type="button" class="qty-btn" id="qty-minus">−</button>
                        <input type="number" id="qty-input" value="1" min="1" max="99" class="qty-field">
                        <button type="button" class="qty-btn" id="qty-plus">+</button>
                    </div>
                    <button class="btn btn--primary" id="add-to-cart-btn"
                            data-id="<?= e($product['id']) ?>">
                        🛒 В корзину
                    </button>
                </div>
                <p class="stock-info">✓ В наличии (<?= $product['stock_fbs'] ?> шт.)</p>
            <?php else: ?>
                <button class="btn btn--outline" disabled>Нет в наличии</button>
            <?php endif ?>

            <!-- Особенности -->
            <?php if (!empty($product['features'])): ?>
                <div class="product-page__features">
                    <?php foreach ($product['features'] as $f): ?>
                        <span class="feature-tag">✓ <?= e($f) ?></span>
                    <?php endforeach ?>
                </div>
            <?php endif ?>

        </div>
    </div>

    <!-- Описание и отзывы -->
    <div class="product-tabs" style="margin-top:48px">

        <div class="tabs-nav">
            <button class="tab-btn tab-btn--active" data-tab="desc">Описание</button>
            <button class="tab-btn" data-tab="reviews">Отзывы (<?= count($reviews) ?>)</button>
        </div>

        <div class="tab-content" id="tab-desc">
            <div class="product-description">
                <p><?= nl2br(e($product['description'])) ?></p>

                <?php if (!empty($product['ozon_id'])): ?>
                    <p style="margin-top:16px;font-size:.85rem;color:var(--muted)">
                        Артикул Ozon: <code><?= e($product['ozon_id']) ?></code>
                        · Штрихкод: <code><?= e($product['barcode'] ?? '—') ?></code>
                    </p>
                <?php endif ?>
            </div>
        </div>

        <div class="tab-content" id="tab-reviews" style="display:none">
            <?php if (empty($reviews)): ?>
                <p style="color:var(--muted);padding:24px 0">Отзывов пока нет. Будьте первым!</p>
            <?php else: ?>
                <div class="reviews-list">
                    <?php foreach ($reviews as $r): ?>
                        <div class="review-item">
                            <div class="review-header">
                                <strong><?= e($r['author']) ?></strong>
                                <span style="color:#f59e0b"><?= str_repeat('★', $r['rating']) ?></span>
                                <span style="color:var(--muted);font-size:.8rem"><?= e($r['created_at']) ?></span>
                            </div>
                            <p><?= e($r['text']) ?></p>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </div>
    </div>

</div>

<style>
.breadcrumb { display:flex; align-items:center; gap:8px; font-size:.85rem; color:var(--muted); margin-bottom:24px; }
.breadcrumb a { color:var(--muted); text-decoration:none; } .breadcrumb a:hover { color:var(--green); }
.product-page { display:grid; grid-template-columns:1fr 1fr; gap:48px; align-items:start; }
.product-page__gallery { position:relative; }
.product-page__img-main { background:var(--green-light); border-radius:var(--radius); aspect-ratio:1; overflow:hidden; display:flex; align-items:center; justify-content:center; }
.product-page__img-main img { width:100%; height:100%; object-fit:cover; }
.product-page__badge { position:absolute; top:16px; left:16px; background:var(--green); color:#fff; font-size:.8rem; font-weight:700; padding:4px 10px; border-radius:6px; }
.product-page__title { font-size:1.6rem; font-weight:800; margin:8px 0; line-height:1.25; }
.product-page__short-desc { color:var(--muted); margin-bottom:16px; }
.product-page__meta { display:flex; flex-wrap:wrap; gap:8px; margin-bottom:20px; }
.meta-item { background:var(--bg-soft); border:1px solid var(--border); border-radius:6px; padding:4px 10px; font-size:.85rem; }
.product-page__price-block { display:flex; align-items:center; gap:12px; margin-bottom:20px; }
.product-page__price { font-size:2rem; font-weight:800; color:var(--green-dark); }
.product-page__price-old { font-size:1.1rem; color:var(--muted); text-decoration:line-through; }
.discount-badge { background:#fee2e2; color:#991b1b; font-size:.8rem; font-weight:700; padding:3px 8px; border-radius:6px; }
.product-page__cart { display:flex; align-items:center; gap:12px; margin-bottom:12px; }
.qty-control { display:flex; align-items:center; border:1.5px solid var(--border); border-radius:var(--radius); overflow:hidden; }
.qty-btn { background:none; border:none; width:36px; height:40px; font-size:1.2rem; cursor:pointer; color:var(--text); }
.qty-btn:hover { background:var(--bg-soft); }
.qty-field { width:48px; height:40px; border:none; border-left:1px solid var(--border); border-right:1px solid var(--border); text-align:center; font-size:1rem; -moz-appearance:textfield; }
.qty-field::-webkit-outer-spin-button, .qty-field::-webkit-inner-spin-button { -webkit-appearance:none; }
.stock-info { font-size:.85rem; color:var(--green); margin-bottom:16px; }
.product-page__features { display:flex; flex-wrap:wrap; gap:8px; margin-top:16px; }
.feature-tag { background:var(--green-light); color:var(--green-dark); font-size:.82rem; padding:4px 10px; border-radius:6px; font-weight:500; }
.tabs-nav { display:flex; gap:0; border-bottom:2px solid var(--border); margin-bottom:24px; }
.tab-btn { background:none; border:none; padding:12px 20px; font-size:.95rem; cursor:pointer; color:var(--muted); border-bottom:2px solid transparent; margin-bottom:-2px; }
.tab-btn--active { color:var(--green); border-bottom-color:var(--green); font-weight:600; }
.product-description { font-size:.95rem; line-height:1.8; color:var(--text); max-width:640px; }
.reviews-list { display:flex; flex-direction:column; gap:16px; }
.review-item { background:var(--bg-soft); border-radius:var(--radius); padding:16px; }
.review-header { display:flex; align-items:center; gap:10px; margin-bottom:8px; }
@media (max-width:768px) { .product-page { grid-template-columns:1fr; } }
</style>

<script>
// Вкладки
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('tab-btn--active'));
        document.querySelectorAll('.tab-content').forEach(c => c.style.display = 'none');
        btn.classList.add('tab-btn--active');
        document.getElementById('tab-' + btn.dataset.tab).style.display = 'block';
    });
});

// Кол-во товара
const minus = document.getElementById('qty-minus');
const plus  = document.getElementById('qty-plus');
const input = document.getElementById('qty-input');
if (minus) {
    minus.addEventListener('click', () => { if (input.value > 1) input.value--; });
    plus.addEventListener('click',  () => { if (input.value < 99) input.value++; });
}

// В корзину с qty
const addBtn = document.getElementById('add-to-cart-btn');
if (addBtn) {
    addBtn.addEventListener('click', async () => {
        const id   = addBtn.dataset.id;
        const qty  = parseInt(input?.value ?? 1);
        const csrf = document.querySelector('meta[name="csrf"]')?.content ?? '';
        addBtn.disabled = true;
        addBtn.textContent = '...';
        try {
            const res  = await fetch('/cart/add', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${encodeURIComponent(id)}&qty=${qty}&_csrf=${encodeURIComponent(csrf)}`,
            });
            const data = await res.json();
            if (data.ok) {
                addBtn.textContent = '✓ Добавлено!';
                const badge = document.querySelector('.cart-badge');
                if (badge) badge.textContent = data.count;
                setTimeout(() => { addBtn.textContent = '🛒 В корзину'; addBtn.disabled = false; }, 2000);
            }
        } catch { addBtn.textContent = '🛒 В корзину'; addBtn.disabled = false; }
    });
}
</script>
<?php include SRC . '/Views/components/faq.php'; ?>
