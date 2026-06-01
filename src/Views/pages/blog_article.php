<?php
/**
 * Страница статьи
 * Переменные: $article, $adjacent, $categories
 */
?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "<?= addslashes(e($article['title'])) ?>",
  "description": "<?= addslashes(e($article['meta_description'] ?? $article['preview'])) ?>",
  "datePublished": "<?= e($article['published_at']) ?>",
  "dateModified": "<?= e($article['updated_at'] ?? $article['published_at']) ?>",
  "publisher": { "@type": "Organization", "name": "Probio-Clean", "url": "<?= APP_URL ?>" },
  "mainEntityOfPage": { "@type": "WebPage", "@id": "<?= APP_URL ?>/blog/<?= e($article['slug']) ?>" }
}
</script>

<div class="container" style="padding: 2rem 0 4rem">

  <!-- Хлебные крошки -->
  <nav class="breadcrumbs" aria-label="Навигация">
    <ol class="breadcrumbs__list" itemscope itemtype="https://schema.org/BreadcrumbList">
      <li class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <a href="/" itemprop="item"><span itemprop="name">Главная</span></a>
        <meta itemprop="position" content="1">
      </li>
      <li class="breadcrumbs__sep">›</li>
      <li class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <a href="/blog" itemprop="item"><span itemprop="name">Блог</span></a>
        <meta itemprop="position" content="2">
      </li>
      <li class="breadcrumbs__sep">›</li>
      <li class="breadcrumbs__item breadcrumbs__item--current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <span itemprop="name"><?= e($article['title']) ?></span>
        <meta itemprop="position" content="3">
      </li>
    </ol>
  </nav>

  <div class="article-layout">

    <!-- Основной контент -->
    <article class="article-content">
      <header class="article-header">
        <div class="article-header__meta">
          <a href="/blog?category=<?= e($article['category']) ?>" class="article-header__cat">
            <?= e(($categories ?? [])[$article['category']] ?? $article['category']) ?>
          </a>
          <time class="article-header__date" datetime="<?= e($article['published_at']) ?>">
            <?= formatDate($article['published_at']) ?>
          </time>
        </div>
        <h1 class="article-header__title"><?= e($article['title']) ?></h1>
        <p class="article-header__lead"><?= e($article['preview']) ?></p>
        <?php if (!empty($article['tags'])): ?>
          <div class="article-header__tags">
            <?php foreach ($article['tags'] as $tag): ?>
              <span class="article-header__tag">#<?= e($tag) ?></span>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </header>

      <div class="article-body">
        <?= $article['content'] ?>
      </div>

      <!-- Навигация prev/next -->
      <?php if (!empty($adjacent['prev']) || !empty($adjacent['next'])): ?>
        <nav class="article-nav">
          <?php if (!empty($adjacent['prev'])): ?>
            <a href="/blog/<?= e($adjacent['prev']['slug']) ?>" class="article-nav__item article-nav__item--prev">
              <span class="article-nav__label">← Предыдущая</span>
              <span class="article-nav__title"><?= e($adjacent['prev']['title']) ?></span>
            </a>
          <?php else: ?><span></span><?php endif; ?>
          <?php if (!empty($adjacent['next'])): ?>
            <a href="/blog/<?= e($adjacent['next']['slug']) ?>" class="article-nav__item article-nav__item--next">
              <span class="article-nav__label">Следующая →</span>
              <span class="article-nav__title"><?= e($adjacent['next']['title']) ?></span>
            </a>
          <?php endif; ?>
        </nav>
      <?php endif; ?>

      <!-- CTA -->
      <div class="article-cta">
        <div class="article-cta__inner">
          <p class="article-cta__text">Убедились, что пробиотические средства работают иначе?</p>
          <a href="/catalog" class="btn btn--primary">Выбрать средство Chrisal</a>
          <a href="/blog" class="btn btn--outline">Все статьи блога</a>
        </div>
      </div>
    </article>

    <!-- Сайдбар -->
    <aside class="article-sidebar">
      <div class="article-sidebar__block">
        <h3 class="article-sidebar__title">Другие статьи</h3>
        <ul class="article-sidebar__list">
          <li><a href="/blog/kak-rabotayut-probioticheskie-sredstva">3 этапа очистки</a></li>
          <li><a href="/blog/chto-takoe-bioplenka">Что такое биоплёнка</a></li>
          <li><a href="/blog/pochemu-hlor-delaet-bakterii-silnee">Почему хлор опасен</a></li>
          <li><a href="/blog/konkurentnoe-vytesnenie-bakteriy">Конкурентное вытеснение</a></li>
          <li><a href="/blog/pyat-shtammov-bacillus">Пять штаммов Bacillus</a></li>
          <li><a href="/blog/bezopasno-dlya-detey-allergikov-zhivotnyh">Безопасность для семьи</a></li>
          <li><a href="/blog/probioticheskiy-klining-v-medicine-i-na-proizvodstve">Медицина и производство</a></li>
        </ul>
      </div>
      <div class="article-sidebar__block article-sidebar__block--cta">
        <p>Один флакон заменяет 8 средств. Работает 3 суток.</p>
        <a href="/catalog" class="btn btn--primary btn--sm">В каталог</a>
      </div>
    </aside>

  </div>
</div>

<?php include __DIR__ . '/../components/faq.php'; ?>
