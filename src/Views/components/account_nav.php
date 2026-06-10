<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<nav class="account-nav">
    <a href="/account"         class="<?= $currentPath === '/account'         ? 'active' : '' ?>">📊 Обзор</a>
    <a href="/account/orders"  class="<?= $currentPath === '/account/orders'  ? 'active' : '' ?>">📦 Мои заказы</a>
    <a href="/account/profile" class="<?= $currentPath === '/account/profile' ? 'active' : '' ?>">👤 Мои данные</a>
    <a href="/logout" style="color:var(--muted)">← Выйти</a>
</nav>
