<meta name="csrf" content="<?= csrfToken() ?>">

<div class="container" style="padding-top:32px;padding-bottom:64px">

    <!-- Заголовок -->
    <div style="margin-bottom:24px">
        <h1 style="font-size:1.8rem;font-weight:800;margin-bottom:4px">Каталог</h1>
        <p style="color:var(--muted);font-size:.95rem">Пробиотические средства Chrisal — <?= count($products) ?> товаров</p>
    </div>

    <div class="catalog-layout">

        <!-- SIDEBAR -->
        <aside class="catalog-sidebar">
            <form method="GET" action="/catalog" id="filter-form">

                <!-- Поиск -->
                <div class="filter-block">
                    <label class="filter-title">Поиск</label>
                    <input type="text" name="q" class="form-input" placeholder="Название товара..."
                           value="<?= e($params['q'] ?? '') ?>">
                </div>

                <!-- Аудитория -->
                <div class="filter-block">
                    <label class="filter-title">Для кого</label>
                    <div class="filter-options">
                        <label class="filter-radio">
                            <input type="radio" name="audience" value=""
                                <?= empty($params['audience']) ? 'checked' : '' ?>>
                            <span>Все товары</span>
                        </label>
                        <label class="filter-radio">
                            <input type="radio" name="audience" value="private"
                                <?= ($params['audience'] ?? '') === 'private' ? 'checked' : '' ?>>
                            <span>🏠 Для дома</span>
                        </label>
                        <label class="filter-radio">
                            <input type="radio" name="audience" value="business"
                                <?= ($params['audience'] ?? '') === 'business' ? 'checked' : '' ?>>
                            <span>💼 Для бизнеса</span>
                        </label>
                    </div>
                </div>

                <!-- Категории -->
                <div class="filter-block">
                    <label class="filter-title">Категория</label>
                    <div class="filter-options">
                        <label class="filter-radio">
                            <input type="radio" name="category" value=""
                                <?= empty($params['category']) ? 'checked' : '' ?>>
                            <span>Все категории</span>
                        </label>
                        <?php foreach ($categories as $cat): ?>
                            <label class="filter-radio">
                                <input type="radio" name="category" value="<?= e($cat['slug']) ?>"
                                    <?= ($params['category'] ?? '') === $cat['slug'] ? 'checked' : '' ?>>
                                <span><?= e($cat['icon']) ?> <?= e($cat['name']) ?></span>
                            </label>
                        <?php endforeach ?>
                    </div>
                </div>

                <!-- Сортировка -->
                <div class="filter-block">
                    <label class="filter-title">Сортировка</label>
                    <select name="sort" class="form-input" onchange="this.form.submit()">
                        <option value="default"    <?= ($params['sort'] ?? '') === 'default'    ? 'selected' : '' ?>>По умолчанию</option>
                        <option value="price_asc"  <?= ($params['sort'] ?? '') === 'price_asc'  ? 'selected' : '' ?>>Цена: по возрастанию</option>
                        <option value="price_desc" <?= ($params['sort'] ?? '') === 'price_desc' ? 'selected' : '' ?>>Цена: по убыванию</option>
                    </select>
                </div>

                <button type="submit" class="btn btn--primary btn--full">Применить</button>

                <?php if (!empty($params['audience']) || !empty($params['category']) || !empty($params['q'])): ?>
                    <a href="/catalog" class="btn btn--outline btn--full" style="margin-top:8px">Сбросить фильтры</a>
                <?php endif ?>

            </form>
        </aside>

        <!-- PRODUCTS -->
        <div class="catalog-main">

            <?php if (empty($products)): ?>
                <div class="empty-state">
                    <div style="font-size:3rem;margin-bottom:12px">🔍</div>
                    <h3>Ничего не найдено</h3>
                    <p style="color:var(--muted)">Попробуйте изменить параметры фильтра</p>
                    <a href="/catalog" class="btn btn--outline" style="margin-top:16px">Сбросить</a>
                </div>
            <?php else: ?>
                <div class="product-grid">
                    <?php foreach ($products as $p): ?>
                        <div class="product-card">
                            <a href="/catalog/<?= e($p['slug']) ?>" class="product-card__img">
                                <?php if (!empty($p['image']) && file_exists(ROOT . '/public' . $p['image'])): ?>
                                    <img src="<?= e($p['image']) ?>" alt="<?= e($p['name']) ?>" style="width:100%;height:100%;object-fit:cover">
                                <?php else: ?>
                                    🧴
                                <?php endif ?>
                            </a>
                            <div class="product-card__body">
                                <?php if (!empty($p['badge'])): ?>
                                    <span class="product-card__badge"><?= e($p['badge']) ?></span>
                                <?php endif ?>

                                <a href="/catalog/<?= e($p['slug']) ?>" class="product-card__name">
                                    <?= e($p['name']) ?>
                                </a>
                                <p class="product-card__desc"><?= e($p['short_desc']) ?></p>

                                <?php if (!empty($p['rating'])): ?>
                                    <div class="product-card__rating">
                                        <span class="stars"><?= str_repeat('★', (int)round($p['rating'])) ?><?= str_repeat('☆', 5 - (int)round($p['rating'])) ?></span>
                                        <span style="color:var(--muted);font-size:.8rem">(<?= $p['reviews_count'] ?>)</span>
                                    </div>
                                <?php endif ?>

                                <div class="product-card__footer">
                                    <div>
                                        <div class="product-card__price"><?= formatPrice($p['price']) ?></div>
                                        <?php if (!empty($p['price_old']) && $p['price_old'] > $p['price']): ?>
                                            <div class="product-card__price-old"><?= formatPrice($p['price_old']) ?></div>
                                        <?php endif ?>
                                    </div>
                                    <button class="btn btn--primary btn--sm" data-add-cart="<?= e($p['id']) ?>">
                                        В корзину
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>

        </div>
    </div>
</div>

<style>
.catalog-layout { display:grid; grid-template-columns:240px 1fr; gap:32px; align-items:start; }
.catalog-sidebar { background:var(--bg); border:1px solid var(--border); border-radius:var(--radius); padding:20px; position:sticky; top:84px; }
.filter-block { margin-bottom:20px; padding-bottom:20px; border-bottom:1px solid var(--border); }
.filter-block:last-child { border-bottom:none; margin-bottom:0; padding-bottom:0; }
.filter-title { display:block; font-size:.8rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em; color:var(--muted); margin-bottom:10px; }
.filter-options { display:flex; flex-direction:column; gap:8px; }
.filter-radio { display:flex; align-items:center; gap:8px; cursor:pointer; font-size:.9rem; }
.filter-radio input { accent-color:var(--green); }
.product-card__rating { display:flex; align-items:center; gap:4px; }
.stars { color:#f59e0b; font-size:.9rem; }
.product-card__price-old { font-size:.8rem; color:var(--muted); text-decoration:line-through; }
.empty-state { text-align:center; padding:64px 20px; }
@media (max-width:768px) {
    .catalog-layout { grid-template-columns:1fr; }
    .catalog-sidebar { position:static; }
}
</style>
<?php include SRC . '/Views/components/faq.php'; ?>
