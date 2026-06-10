<?php
/**
 * Админка: форма создания / редактирования статьи
 * Переменные: $article (null при создании), $categories
 */
$isEdit = $article !== null;
$action = $isEdit ? '/admin/blog/edit/' . $article['slug'] : '/admin/blog/create';
?>

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
  <h2 style="font-size:1.1rem;font-weight:700"><?= $isEdit ? 'Редактировать статью' : 'Новая статья' ?></h2>
  <a href="/admin/blog" class="btn btn-outline">← Назад</a>
</div>

<?php if ($msg = flashGet('error')): ?>
  <div class="alert alert-error"><?= e($msg) ?></div>
<?php endif; ?>

<form method="POST" action="<?= $action ?>">

  <div style="display:grid;grid-template-columns:1fr 260px;gap:20px;align-items:start">

    <!-- Левая колонка -->
    <div style="display:flex;flex-direction:column;gap:16px">

      <div class="admin-card" style="padding:20px;display:flex;flex-direction:column;gap:16px">

        <div class="form-group" style="margin:0">
          <label class="form-label">Заголовок <span style="color:#ef4444">*</span></label>
          <input type="text" name="title" class="form-input" required
                 value="<?= e($article['title'] ?? '') ?>"
                 oninput="autoSlug(this.value)">
        </div>

        <div class="form-group" style="margin:0">
          <label class="form-label">URL slug</label>
          <div style="display:flex;border:1.5px solid var(--border);border-radius:8px;overflow:hidden;background:#fff">
            <span style="padding:9px 8px 9px 12px;background:#f9fafb;color:var(--muted);font-size:.85rem;border-right:1px solid var(--border);white-space:nowrap">/blog/</span>
            <input type="text" id="slug" name="slug" class="form-input"
                   style="border:none;border-radius:0;flex:1"
                   placeholder="генерируется автоматически"
                   value="<?= e($article['slug'] ?? '') ?>">
          </div>
        </div>

        <div class="form-group" style="margin:0">
          <label class="form-label">Анонс (preview) <span style="color:#ef4444">*</span></label>
          <textarea name="preview" class="form-input" rows="3" required
                    style="resize:vertical;line-height:1.6"><?= e($article['preview'] ?? '') ?></textarea>
          <div style="font-size:.75rem;color:var(--muted);margin-top:4px">Отображается в карточке на странице блога</div>
        </div>

        <div class="form-group" style="margin:0">
          <label class="form-label">Meta description</label>
          <textarea name="meta_description" class="form-input" rows="2"
                    style="resize:vertical"><?= e($article['meta_description'] ?? '') ?></textarea>
          <div style="font-size:.75rem;color:var(--muted);margin-top:4px">Если пусто — используется анонс</div>
        </div>

        <div class="form-group" style="margin:0">
          <label class="form-label">Контент (HTML) <span style="color:#ef4444">*</span></label>
          <textarea name="content" class="form-input" rows="28" required
                    style="resize:vertical;font-family:'Courier New',monospace;font-size:.82rem;line-height:1.6"><?= e($article['content'] ?? '') ?></textarea>
          <div style="font-size:.75rem;color:var(--muted);margin-top:4px">HTML: &lt;h2&gt;, &lt;p&gt;, &lt;strong&gt;, &lt;ul&gt;&lt;li&gt; и т.д.</div>
        </div>

      </div>
    </div>

    <!-- Правая колонка -->
    <div style="display:flex;flex-direction:column;gap:12px;position:sticky;top:20px">

      <!-- Публикация -->
      <div class="admin-card" style="padding:16px">
        <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--muted);margin-bottom:12px">Публикация</div>
        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.9rem;margin-bottom:12px">
          <input type="checkbox" name="published" value="1"
                 <?= !empty($article['published']) ? 'checked' : '' ?>
                 style="width:1rem;height:1rem;accent-color:var(--accent)">
          Опубликовать
        </label>
        <?php if ($isEdit): ?>
          <div style="font-size:.75rem;color:var(--muted);margin-bottom:8px">Создана: <?= e($article['published_at']) ?></div>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
          <?= $isEdit ? 'Сохранить' : 'Создать статью' ?>
        </button>
      </div>

      <!-- Категория -->
      <div class="admin-card" style="padding:16px">
        <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--muted);margin-bottom:10px">Категория</div>
        <select name="category" class="form-input">
          <?php foreach (($categories ?? []) as $key => $label): ?>
            <option value="<?= e($key) ?>" <?= ($article['category'] ?? 'technology') === $key ? 'selected' : '' ?>>
              <?= e($label) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Теги -->
      <div class="admin-card" style="padding:16px">
        <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--muted);margin-bottom:10px">Теги</div>
        <input type="text" name="tags" class="form-input"
               placeholder="тег1, тег2, тег3"
               value="<?= e(implode(', ', $article['tags'] ?? [])) ?>">
        <div style="font-size:.75rem;color:var(--muted);margin-top:4px">Через запятую</div>
      </div>

      <?php if ($isEdit): ?>
        <div class="admin-card" style="padding:16px">
          <a href="/blog/<?= e($article['slug']) ?>" target="_blank"
             class="btn btn-outline" style="width:100%;justify-content:center">
            Смотреть на сайте ↗
          </a>
        </div>
      <?php endif; ?>

    </div>
  </div>

</form>

<script>
const slugInput = document.getElementById('slug');
const isEdit = <?= $isEdit ? 'true' : 'false' ?>;
function autoSlug(title) {
  if (isEdit) return;
  const map = {
    'а':'a','б':'b','в':'v','г':'g','д':'d','е':'e','ё':'yo','ж':'zh','з':'z',
    'и':'i','й':'y','к':'k','л':'l','м':'m','н':'n','о':'o','п':'p','р':'r',
    'с':'s','т':'t','у':'u','ф':'f','х':'h','ц':'ts','ч':'ch','ш':'sh',
    'щ':'sch','ъ':'','ы':'y','ь':'','э':'e','ю':'yu','я':'ya',' ':'-'
  };
  let s = title.toLowerCase();
  s = s.split('').map(c => map[c] !== undefined ? map[c] : c).join('');
  s = s.replace(/[^a-z0-9\-]/g, '').replace(/-+/g, '-').replace(/^-|-$/g, '');
  slugInput.value = s;
}
</script>
