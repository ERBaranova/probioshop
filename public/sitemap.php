<?php
define('ROOT', dirname(__DIR__));
require ROOT . '/config/config.php';

header('Content-Type: application/xml; charset=utf-8');

$products   = json_decode(file_get_contents(DATA_PRODUCTS),   true) ?? [];
$categories = json_decode(file_get_contents(DATA_CATEGORIES), true) ?? [];
$today      = date('Y-m-d');

$urls = [
    ['loc' => APP_URL . '/',           'lastmod' => $today,        'changefreq' => 'weekly',  'priority' => '1.0'],
    ['loc' => APP_URL . '/catalog',    'lastmod' => $today,        'changefreq' => 'daily',   'priority' => '0.9'],
    ['loc' => APP_URL . '/technology', 'lastmod' => '2025-01-01',  'changefreq' => 'monthly', 'priority' => '0.8'],
];

foreach (['private', 'business'] as $aud) {
    $urls[] = ['loc' => APP_URL . '/catalog?audience=' . $aud, 'lastmod' => $today, 'changefreq' => 'weekly', 'priority' => '0.8'];
}

foreach ($categories as $cat) {
    $urls[] = ['loc' => APP_URL . '/catalog?category=' . urlencode($cat['slug']), 'lastmod' => $today, 'changefreq' => 'weekly', 'priority' => '0.7'];
}

foreach ($products as $p) {
    if (empty($p['in_stock'])) continue;
    $urls[] = [
        'loc'        => APP_URL . '/catalog/' . rawurlencode($p['slug']),
        'lastmod'    => $p['created_at'] ?? $today,
        'changefreq' => 'monthly',
        'priority'   => '0.8',
    ];
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($urls as $url) {
    echo "  <url>\n";
    echo "    <loc>" . htmlspecialchars($url['loc'], ENT_XML1) . "</loc>\n";
    echo "    <lastmod>{$url['lastmod']}</lastmod>\n";
    echo "    <changefreq>{$url['changefreq']}</changefreq>\n";
    echo "    <priority>{$url['priority']}</priority>\n";
    echo "  </url>\n";
}
echo '</urlset>';
