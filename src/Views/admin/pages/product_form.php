<?php $isEdit = !empty($product); ?>
<?php if (!empty($error)): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif ?>

<form method="POST" action="<?= $isEdit ? '/admin/products/' . e($product['id']) : '/admin/products' ?>">
    <input type="hidden" name="_csrf" value="<?= csrfToken() ?>">

    <div style="display:grid;grid-template-columns:1fr 320px;gap:24px;align-items:start">

        <!-- Основная колонка -->
        <div>
            <div class="admin-card" style="margin-bottom:16px">
                <div class="admin-card-header"><h2>Основное</h2></div>
                <div style="padding:20px">
                    <div class="form-group">
                        <label class="form-label">Название товара *</label>
                        <input type="text" name="name" class="form-input" required
                               value="<?= e($product['name'] ?? '') ?>" placeholder="PIP Sanitary Cleaner 1 л">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Короткое описание</label>
                        <input type="text" name="short_desc" class="form-input"
                               value="<?= e($product['short_desc'] ?? '') ?>"
                               placeholder="Для карточки в каталоге (1–2 предложения)">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Полное описание</label>
                        <textarea name="description" class="form-input" rows="5"
                                  style="resize:vertical"
                                  placeholder="Подробное описание товара для страницы товара"><?= e($product['description'] ?? '') ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Особенности (по одной на строку)</label>
                        <textarea name="features" class="form-input" rows="4" style="resize:vertical"
                                  placeholder="Без хлора&#10;Гипоаллергенно&#10;Концентрат 1:10"><?= e(implode("\n", $product['features'] ?? [])) ?></textarea>
                    </div>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-header"><h2>Изображение</h2></div>
                <div style="padding:20px">
                    <div class="form-group">
                        <label class="form-label">Путь к изображению</label>
                        <input type="text" name="image" class="form-input"
                               value="<?= e($product['image'] ?? '') ?>"
                               placeholder="/img/products/название-файла.jpg">
                        <p style="font-size:.75rem;color:var(--muted);margin-top:4px">
                            Загрузи файл в <code>public/img/products/</code> и укажи путь
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Правая колонка -->
        <div>
            <div class="admin-card" style="margin-bottom:16px">
                <div class="admin-card-header"><h2>Цена и наличие</h2></div>
                <div style="padding:20px">
                    <div class="form-row" style="margin-bottom:16px">
                        <div class="form-group" style="margin:0">
                            <label class="form-label">Цена ₽ *</label>
                            <input type="number" name="price" class="form-input" required step="0.01"
                                   value="<?= e($product['price'] ?? '') ?>" placeholder="5400">
                        </div>
                        <div class="form-group" style="margin:0">
                            <label class="form-label">Цена до скидки ₽</label>
                            <input type="number" name="price_old" class="form-input" step="0.01"
                                   value="<?= e($product['price_old'] ?? '') ?>" placeholder="6000">
                        </div>
                    </div>
                    <div class="form-row" style="margin-bottom:16px">
                        <div class="form-group" style="margin:0">
                            <label class="form-label">Объём</label>
                            <input type="number" name="volume" class="form-input"
                                   value="<?= e($product['volume'] ?? '') ?>" placeholder="1000">
                        </div>
                        <div class="form-group" style="margin:0">
                            <label class="form-label">Ед. изм.</label>
                            <select name="unit" class="form-input">
                                <?php foreach (['мл','л','г','кг','шт'] as $u): ?>
                                    <option <?= ($product['unit'] ?? 'мл') === $u ? 'selected' : '' ?>><?= $u ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Остаток (FBS), шт.</label>
                        <input type="number" name="stock_fbs" class="form-input"
                               value="<?= e($product['stock_fbs'] ?? 0) ?>">
                    </div>
                    <label style="display:flex;align-items:center;gap:10px;cursor:pointer;font-size:.875rem;font-weight:600">
                        <label class="toggle"><input type="checkbox" name="in_stock" <?= !empty($product['in_stock']) ? 'checked' : '' ?>>
                            <span class="toggle-slider"></span></label>
                        В наличии
                    </label>
                </div>
            </div>

            <div class="admin-card" style="margin-bottom:16px">
                <div class="admin-card-header"><h2>Категория и аудитория</h2></div>
                <div style="padding:20px">
                    <div class="form-group">
                        <label class="form-label">Категория</label>
                        <select name="category" class="form-input">
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= e($cat['slug']) ?>" <?= ($product['category'] ?? '') === $cat['slug'] ? 'selected' : '' ?>>
                                    <?= e($cat['icon']) ?> <?= e($cat['name']) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Тип товара</label>
                        <input type="text" name="type" class="form-input"
                               value="<?= e($product['type'] ?? '') ?>" placeholder="Чистящее средство">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Аудитория</label>
                        <div style="display:flex;flex-direction:column;gap:8px;margin-top:4px">
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.875rem">
                                <input type="checkbox" name="audience_private"
                                       <?= in_array('private', $product['audience'] ?? []) ? 'checked' : '' ?>>
                                🏠 Для дома
                            </label>
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.875rem">
                                <input type="checkbox" name="audience_business"
                                       <?= in_array('business', $product['audience'] ?? []) ? 'checked' : '' ?>>
                                💼 Для бизнеса
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-card" style="margin-bottom:16px">
                <div class="admin-card-header"><h2>Отображение</h2></div>
                <div style="padding:20px">
                    <div class="form-group">
                        <label class="form-label">Бейдж (опционально)</label>
                        <input type="text" name="badge" class="form-input"
                               value="<?= e($product['badge'] ?? '') ?>"
                               placeholder="Хит / Новинка / Для бизнеса">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Бренд</label>
                        <input type="text" name="brand" class="form-input"
                               value="<?= e($product['brand'] ?? 'Chrisal') ?>">
                    </div>
                </div>
            </div>

            <div style="display:flex;gap:10px">
                <button type="submit" class="btn btn-primary" style="flex:1">
                    <?= $isEdit ? '💾 Сохранить' : '➕ Добавить товар' ?>
                </button>
                <a href="/admin/products" class="btn btn-outline">Отмена</a>
            </div>
        </div>

    </div>
</form>
