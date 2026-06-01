<?php
/**
 * Список статей блога
 * Переменные из BaseController->render(): $articles, $categories, $category, $search
 */
?>
<section class="blog-hero">
  <div class="container">
    <h1 class="blog-hero__title">Блог Probio-Clean</h1>
    <p class="blog-hero__sub">Разбираем технологию пробиотической уборки: как работает, почему безопасна, где применяется</p>
  </div>
</section>

<div class="container">

  <!-- Фильтры -->
  <div class="blog-filters">
    <form class="blog-filters__form" method="GET" action="/blog">
      <div class="blog-filters__search">
        <input type="search" name="q" class="blog-filters__input"
               placeholder="Поиск по статьям…"
               value="<?= e($search ?? '') ?>">
        <button type="submit" class="blog-filters__search-btn" aria-label="Найти">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
          </svg>
        </button>
      </div>
      <div class="blog-filters__cats">
        <a href="/blog" class="blog-filters__cat <?= !($category ?? '') ? 'blog-filters__cat--active' : '' ?>">
          Все статьи
        </a>
        <?php foreach (($categories ?? []) as $key => $label): ?>
          <a href="/blog?category=<?= e($key) ?><?= !empty($search) ? '&q=' . urlencode($search) : '' ?>"
             class="blog-filters__cat <?= ($category ?? '') === $key ? 'blog-filters__cat--active' : '' ?>">
            <?= e($label) ?>
          </a>
        <?php endforeach; ?>
      </div>
    </form>
  </div>

  <!-- Инфо о поиске -->
  <?php if (!empty($search)): ?>
    <p class="blog-search-info">
      <?php $cnt = count($articles ?? []); ?>
      <?php if ($cnt): ?>
        Найдено <?= $cnt ?> <?= nounForm($cnt, 'статья', 'статьи', 'статей') ?>
        по запросу «<?= e($search) ?>»
      <?php else: ?>
        По запросу «<?= e($search) ?>» ничего не найдено.
        <a href="/blog">Показать все статьи</a>
      <?php endif; ?>
    </p>
  <?php endif; ?>

  <!-- Сетка -->
  <?php if (!empty($articles)): ?>
    <div class="blog-grid">
      <?php foreach ($articles as $i => $article): ?>
        <article class="blog-card <?= $i === 0 && empty($search) && empty($category) ? 'blog-card--featured' : '' ?>">
          <div class="blog-card__meta">
            <span class="blog-card__cat"><?= e(($categories ?? [])[$article['category']] ?? $article['category']) ?></span>
            <time class="blog-card__date" datetime="<?= e($article['published_at']) ?>">
              <?= formatDate($article['published_at']) ?>
            </time>
          </div>
          <h2 class="blog-card__title">
            <a href="/blog/<?= e($article['slug']) ?>" class="blog-card__link">
              <?= e($article['title']) ?>
            </a>
          </h2>
          <p class="blog-card__preview"><?= e($article['preview']) ?></p>
          <?php if (!empty($article['tags'])): ?>
            <div class="blog-card__tags">
              <?php foreach (array_slice($article['tags'], 0, 3) as $tag): ?>
                <span class="blog-card__tag">#<?= e($tag) ?></span>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
          <a href="/blog/<?= e($article['slug']) ?>" class="blog-card__read">
            Читать статью
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
          </a>
        </article>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="blog-empty"><p>Статей пока нет.</p></div>
  <?php endif; ?>

</div>

<?php include __DIR__ . '/../components/faq.php'; ?>
