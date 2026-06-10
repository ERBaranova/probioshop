<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if (!empty($seo)): ?>
        <?= $seo->renderMeta() ?>
        <?= $seo->renderSchema() ?>
    <?php else: ?>
        <title><?= e($title ?? APP_NAME) ?></title>
        <meta name="description" content="Chrisal — пробиотические моющие средства. Работают 14 суток, безопасны для детей и животных, сертифицированы для медучреждений.">
    <?php endif; ?>
    <link rel="icon" type="image/png" href="/img/logo.png">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>

<header class="header">
    <div class="container header__inner">
        <a href="/" class="logo">
            <img src="/img/logo.png" alt="Probio-Clean" style="height:36px">
            <span><?= APP_NAME ?></span>
        </a>

        <nav class="nav">
            <a href="/catalog?audience=private"  class="nav__link">Для дома</a>
            <a href="/b2b" class="nav__link">Для бизнеса</a>
            <a href="/catalog"                   class="nav__link">Каталог</a>
            <a href="/technology"                class="nav__link">Технология</a>
            <a href="/blog"                      class="nav__link">Блог</a>
        </nav>

        <div class="header__actions">
            <a href="/cart" class="btn-cart" title="Корзина">
                🛒
                <?php if ($cartCount = (new BaseController())->cartCount()): ?>
                    <span class="cart-badge"><?= $cartCount ?></span>
                <?php endif ?>
            </a>
            <?php if (isLoggedIn()): ?>
                <a href="/account" class="btn btn--outline btn--sm">Кабинет</a>
            <?php else: ?>
                <a href="/login" class="btn btn--ghost btn--sm">Войти</a>
                <a href="/register" class="btn btn--primary btn--sm">Регистрация</a>
            <?php endif ?>
        </div>
    </div>
</header>

<main class="main">
    <?php if ($flash = flashGet('success')): ?>
        <div class="container" style="padding-top:12px">
            <div class="alert alert--success"><?= e($flash) ?></div>
        </div>
    <?php endif ?>
    <?= $content ?>
</main>

<footer class="footer">
    <div class="container footer__inner">
        <div style="display:flex;align-items:center;gap:8px">
            <img src="/img/logo.png" alt="Probio-Clean" style="height:28px">
            <div>
                <div style="font-weight:800;font-size:.9rem;color:var(--green-dark)"><?= APP_NAME ?></div>
                <div class="footer__copy">Интернет-магазин пробиотических средств Chrisal</div>
            </div>
        </div>
        <nav class="footer__nav">
            <a href="/catalog">Каталог</a>
            <a href="/catalog?audience=business">Для бизнеса</a>
            <a href="/technology">Технология</a>
            <a href="/blog">Блог</a>
            <a href="/login">Личный кабинет</a>
        </nav>
    </div>
</footer>

<script src="/js/app.js"></script>
</body>
</html>
