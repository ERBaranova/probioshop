<?php
/**
 * SeoHelper v2 — полная поддержка Google Rich Results 2025.
 *
 * Что проверено по Google Search Central (декабрь 2025):
 * - Product: name + offers(price, priceCurrency, availability) + aggregateRating
 * - availability: только https://schema.org/InStock — строки не принимаются
 * - itemCondition: https://schema.org/NewCondition — нужен для Merchant Listings
 * - OfferShippingDetails: усиливает eligibility
 * - FAQPage: вопросы должны быть видны на странице (не только в JSON-LD)
 * - BreadcrumbList: item — полный URL обязателен
 * - SearchAction: target — EntryPoint с urlTemplate
 */
class SeoHelper
{
    private string $title       = '';
    private string $description = '';
    private string $canonical   = '';
    private string $ogImage     = '';
    private bool   $noindex     = false;
    private array  $schemas     = [];

    public function forHome(): self
    {
        $this->title       = 'Купить моющие пробиотики Chrisal — ' . APP_NAME;
        $this->description = 'Интернет магазин продукции Chrisal в России. Пробиотические чистящие средства без химии: работают 3 суток, безопасны для детей и животных, сертифицированы для медучреждений. Доставка по РФ.';
        $this->canonical   = APP_URL . '/';
        $this->ogImage     = APP_URL . '/img/og-home.jpg';
        $this->addSchema($this->schemaOrganization());
        $this->addSchema($this->schemaWebSite());
        return $this;
    }

    public function forCatalog(array $params = [], array $categories = [], array $products = []): self
    {
        $audience = $params['audience'] ?? '';
        $category = $params['category'] ?? '';
        $search   = $params['q'] ?? '';

        if ($audience === 'private') {
            $this->title       = 'Моющие средства без химии для дома — каталог Chrisal';
            $this->description = 'Экологичные пробиотические средства для уборки дома: кухня, ванная, полы, стирка. Без хлора, фосфатов и ПАВ. Безопасно для детей и животных. Доставка по России.';
        } elseif ($audience === 'business') {
            $this->title       = 'Профессиональные пробиотические средства для бизнеса — Chrisal';
            $this->description = 'Концентраты Chrisal для клининга, ресторанов, отелей и медучреждений. Экономия 60–80%, сертификат для хирургических кабинетов, ХАССП-совместимо.';
        } elseif ($category) {
            $catName = '';
            foreach ($categories as $c) {
                if ($c['slug'] === $category) { $catName = $c['name']; break; }
            }
            $this->title       = ($catName ? $catName . ' — ' : '') . 'пробиотические средства Chrisal';
            $this->description = 'Купить пробиотические средства Chrisal в категории «' . $catName . '». Без химии, работают до 3 суток. Доставка по России.';
        } elseif ($search) {
            $this->title       = 'Поиск: «' . mb_substr(strip_tags($search), 0, 40) . '» — ' . APP_NAME;
            $this->description = 'Результаты поиска в каталоге пробиотических средств Chrisal.';
            $this->noindex     = true;
        } else {
            $this->title       = 'Каталог пробиотических моющих средств Chrisal — купить в России';
            $this->description = 'Полный каталог моющих пробиотиков Chrisal: для дома, бизнеса, ветеринарии и водоёмов. Без хлора, без ПАВ. Работают 3 суток после нанесения. Официальный дистрибьютор.';
        }

        $canonical = APP_URL . '/catalog';
        $keep = array_filter(['audience' => $audience, 'category' => $category]);
        if ($keep) $canonical .= '?' . http_build_query($keep);
        $this->canonical = $canonical;

        if (!empty($params['sort']) && $params['sort'] !== 'default') {
            $this->noindex = true;
        }
        if (!empty($products)) {
            $this->addSchema($this->schemaItemList($products));
        }
        return $this;
    }

    public function forProduct(array $product, array $reviews = []): self
    {
        $price = number_format((float)$product['price'], 0, ',', ' ');
        $vol   = trim(($product['volume'] ?? '') . ' ' . ($product['unit'] ?? ''));

        $this->title       = $product['name'] . ' купить — ' . $price . ' ₽ | ' . APP_NAME;
        $this->description = $product['short_desc'] . ' Chrisal, ' . $vol . '. Работает 3 суток, без химии. Доставка по России.';
        $this->canonical   = APP_URL . '/catalog/' . $product['slug'];
        $this->ogImage     = !empty($product['image']) ? APP_URL . $product['image'] : APP_URL . '/img/og-home.jpg';

        $this->addSchema($this->schemaProduct($product, $reviews));
        $this->addSchema($this->schemaBreadcrumbs([
            ['name' => 'Главная',        'url' => '/'],
            ['name' => 'Каталог',        'url' => '/catalog'],
            ['name' => $product['name'], 'url' => '/catalog/' . $product['slug']],
        ]));
        return $this;
    }

    public function forTechnology(): self
    {
        $this->title       = 'Как работают моющие пробиотики — технология Chrisal';
        $this->description = 'Механизм пробиотических чистящих средств: Bacillus subtilis, разрушение биоплёнки, 72 часа активности. Сертификаты Гентского университета, NATO, Boeing.';
        $this->canonical   = APP_URL . '/technology';
        $this->ogImage     = APP_URL . '/img/og-home.jpg';

        $this->addSchema($this->schemaBreadcrumbs([
            ['name' => 'Главная',    'url' => '/'],
            ['name' => 'Технология', 'url' => '/technology'],
        ]));
        $this->addSchema($this->schemaFaq([
            ['q' => 'Как работают моющие пробиотики?',
             'a' => 'Пробиотики используют метод конкурентного вытеснения: полезные бактерии Bacillus вытесняют патогенные, расщепляют биоплёнку и органику до CO₂ и воды. Остаются активными до 72 часов после нанесения — обычные средства перестают работать сразу.'],
            ['q' => 'Безопасны ли средства Chrisal для детей и животных?',
             'a' => 'Да. Все средства Chrisal не содержат хлора, фосфатов и агрессивных ПАВ. Сертифицированы CEBETOX (Бельгия) как нетоксичные при пероральном воздействии. Можно использовать без перчаток и масок.'],
            ['q' => 'Чем пробиотики лучше обычных моющих средств?',
             'a' => 'Обычные средства работают только в момент уборки. Пробиотики продолжают уничтожать патогены 3 суток после высыхания, проникают в микропоры и разрушают биоплёнку — защитный щит вредных бактерий.'],
            ['q' => 'Можно ли мыть посуду пробиотическими средствами?',
             'a' => 'Да. Средства Chrisal PIP разработаны для мытья посуды и всех поверхностей на кухне. Биоразлагаемый состав безопасен для слива в канализацию.'],
            ['q' => 'Для каких объектов сертифицированы средства Chrisal?',
             'a' => 'Chrisal сертифицирован для медучреждений (включая хирургические кабинеты), пищевой промышленности (ХАССП), авиации (Boeing, Douglas), армии стран НАТО, сельского хозяйства и ветеринарии.'],
            ['q' => 'Что такое биоплёнка и почему её сложно убрать?',
             'a' => 'Биоплёнка — защитный матрикс, который патогенные бактерии создают на поверхностях. Обычные дезинфектанты работают снаружи и не проникают внутрь. Ферменты Chrisal разрушают матрикс, после чего пробиотики вытесняют патогены полностью.'],
        ]));
        return $this;
    }

    public function forLogin(): self    { $this->title = 'Войти — ' . APP_NAME; $this->canonical = APP_URL . '/login'; $this->noindex = true; return $this; }
    public function forRegister(): self { $this->title = 'Регистрация — ' . APP_NAME; $this->canonical = APP_URL . '/register'; $this->noindex = true; return $this; }
    public function forAccount(): self  { $this->title = 'Личный кабинет — ' . APP_NAME; $this->noindex = true; return $this; }
    public function forCart(): self     { $this->title = 'Корзина — ' . APP_NAME; $this->noindex = true; return $this; }
    public function forOrder(): self    { $this->title = 'Оформление заказа — ' . APP_NAME; $this->noindex = true; return $this; }
    public function forB2b(): self
    {
        $this->title       = 'Пробиотические средства для бизнеса — оптовые поставки Chrisal';
        $this->description = 'Профессиональные пробиотические моющие средства Chrisal для ресторанов, медучреждений, отелей, ферм. Экономия 60–80%, сертификат для хирургии, ХАССП. Запросите КП.';
        $this->canonical   = APP_URL . '/b2b';
        $this->ogImage     = APP_URL . '/img/og-b2b.jpg';
        $this->addSchema($this->schemaBreadcrumbs([
            ['name' => 'Главная',      'url' => '/'],
            ['name' => 'Для бизнеса', 'url' => '/b2b'],
        ]));
        return $this;
    }


    public function forBlog(string $category = '', string $search = ''): self
    {
        if ($search) {
            $this->title   = 'Поиск: «' . mb_substr($search, 0, 40) . '» — Блог ' . APP_NAME;
            $this->noindex = true;
        } else {
            $this->title = 'Блог — пробиотические моющие средства Chrisal';
        }
        $this->description = 'Статьи о пробиотических моющих средствах: как работает технология, чем опасен хлор, что такое биоплёнка и почему больницы выбирают Chrisal.';
        $this->canonical   = APP_URL . '/blog';
        $this->addSchema($this->schemaBreadcrumbs([
            ['name' => 'Главная', 'url' => '/'],
            ['name' => 'Блог',    'url' => '/blog'],
        ]));
        return $this;
    }

    public function forBlogArticle(array $article): self
    {
        $this->title       = $article['title'] . ' — ' . APP_NAME;
        $this->description = $article['meta_description'] ?? $article['preview'];
        $this->canonical   = APP_URL . '/blog/' . $article['slug'];
        $this->ogImage     = APP_URL . '/img/og-home.jpg';
        $this->addSchema([
            '@context'         => 'https://schema.org',
            '@type'            => 'Article',
            'headline'         => $article['title'],
            'description'      => $article['meta_description'] ?? $article['preview'],
            'datePublished'    => $article['published_at'],
            'dateModified'     => $article['updated_at'] ?? $article['published_at'],
            'publisher'        => ['@type' => 'Organization', 'name' => APP_NAME, 'url' => APP_URL],
            'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => APP_URL . '/blog/' . $article['slug']],
        ]);
        $this->addSchema($this->schemaBreadcrumbs([
            ['name' => 'Главная',         'url' => '/'],
            ['name' => 'Блог',            'url' => '/blog'],
            ['name' => $article['title'], 'url' => '/blog/' . $article['slug']],
        ]));
        return $this;
    }
    public function for404(): self      { $this->title = 'Страница не найдена — ' . APP_NAME; $this->noindex = true; return $this; }

    // ─── HTML ────────────────────────────────────────────────────────────────

    public function renderMeta(): string
    {
        $t  = htmlspecialchars($this->title ?: APP_NAME, ENT_QUOTES, 'UTF-8');
        $d  = htmlspecialchars($this->description, ENT_QUOTES, 'UTF-8');
        $c  = htmlspecialchars($this->canonical ?: APP_URL . $_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8');
        $im = htmlspecialchars($this->ogImage ?: APP_URL . '/img/og-home.jpg', ENT_QUOTES, 'UTF-8');
        $ri = $this->noindex
            ? '<meta name="robots" content="noindex,nofollow">'
            : '<meta name="robots" content="index,follow">';

        return <<<HTML
    <title>{$t}</title>
    <meta name="description" content="{$d}">
    {$ri}
    <link rel="canonical" href="{$c}">
    <meta property="og:type"         content="website">
    <meta property="og:locale"       content="ru_RU">
    <meta property="og:site_name"    content="Probio-Clean">
    <meta property="og:title"        content="{$t}">
    <meta property="og:description"  content="{$d}">
    <meta property="og:url"          content="{$c}">
    <meta property="og:image"        content="{$im}">
    <meta property="og:image:width"  content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt"    content="{$t}">
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="{$t}">
    <meta name="twitter:description" content="{$d}">
    <meta name="twitter:image"       content="{$im}">
HTML;
    }

    public function renderSchema(): string
    {
        if (empty($this->schemas)) return '';
        $out = '';
        foreach ($this->schemas as $schema) {
            $json = json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            $out .= "\n    <script type=\"application/ld+json\">\n{$json}\n    </script>";
        }
        return $out;
    }

    public function getTitle(): string { return $this->title ?: APP_NAME; }

    // ─── Schema.org ──────────────────────────────────────────────────────────

    private function schemaOrganization(): array
    {
        return [
            '@context'     => 'https://schema.org',
            '@type'        => 'Organization',
            '@id'          => APP_URL . '/#organization',
            'name'         => APP_NAME,
            'url'          => APP_URL,
            'logo'         => ['@type' => 'ImageObject', 'url' => APP_URL . '/img/logo.png', 'width' => 200, 'height' => 60],
            'description'  => 'Интернет магазин продукции Chrisal в России. Пробиотические моющие средства без химии.',
            'contactPoint' => ['@type' => 'ContactPoint', 'contactType' => 'customer service', 'availableLanguage' => ['Russian']],
        ];
    }

    private function schemaWebSite(): array
    {
        return [
            '@context'        => 'https://schema.org',
            '@type'           => 'WebSite',
            '@id'             => APP_URL . '/#website',
            'name'            => APP_NAME,
            'url'             => APP_URL,
            'publisher'       => ['@id' => APP_URL . '/#organization'],
            'potentialAction' => [
                '@type'       => 'SearchAction',
                'target'      => ['@type' => 'EntryPoint', 'urlTemplate' => APP_URL . '/catalog?q={search_term_string}'],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    private function schemaProduct(array $p, array $reviews): array
    {
        $schema = [
            '@context'    => 'https://schema.org',
            '@type'       => 'Product',
            'name'        => $p['name'],
            'description' => $p['description'] ?? $p['short_desc'],
            'sku'         => $p['sku'] ?? $p['id'],
            'brand'       => ['@type' => 'Brand', 'name' => $p['brand'] ?? 'Chrisal'],
            'offers'      => [
                '@type'           => 'Offer',
                'url'             => APP_URL . '/catalog/' . $p['slug'],
                'priceCurrency'   => 'RUB',
                'price'           => number_format((float)$p['price'], 2, '.', ''),
                'availability'    => $p['in_stock']
                    ? 'https://schema.org/InStock'
                    : 'https://schema.org/OutOfStock',
                'itemCondition'   => 'https://schema.org/NewCondition',
                'priceValidUntil' => date('Y-12-31'),
                'seller'          => ['@type' => 'Organization', 'name' => APP_NAME],
                'hasMerchantReturnPolicy' => [
                    '@type'            => 'MerchantReturnPolicy',
                    'applicableCountry'=> 'RU',
                    'returnPolicyCategory' => 'https://schema.org/MerchantReturnFiniteReturnWindow',
                    'merchantReturnDays'   => 14,
                    'returnMethod'         => 'https://schema.org/ReturnByMail',
                ],
                'shippingDetails' => [
                    '@type'        => 'OfferShippingDetails',
                    'shippingRate' => ['@type' => 'MonetaryAmount', 'value' => '0', 'currency' => 'RUB'],
                    'deliveryTime' => [
                        '@type'       => 'ShippingDeliveryTime',
                        'handlingTime'=> ['@type' => 'QuantitativeValue', 'minValue' => 0, 'maxValue' => 1, 'unitCode' => 'DAY'],
                        'transitTime' => ['@type' => 'QuantitativeValue', 'minValue' => 2, 'maxValue' => 7, 'unitCode' => 'DAY'],
                    ],
                    'shippingDestination' => ['@type' => 'DefinedRegion', 'addressCountry' => 'RU'],
                ],
            ],
        ];

        if (!empty($p['image'])) {
            $schema['image'] = ['@type' => 'ImageObject', 'url' => APP_URL . $p['image']];
        }

        if (!empty($p['rating']) && $p['rating'] > 0 && ($p['reviews_count'] ?? 0) > 0) {
            $schema['aggregateRating'] = [
                '@type'       => 'AggregateRating',
                'ratingValue' => number_format((float)$p['rating'], 1, '.', ''),
                'reviewCount' => (int)$p['reviews_count'],
                'bestRating'  => '5',
                'worstRating' => '1',
            ];
        }

        if (!empty($reviews)) {
            $schema['review'] = array_map(fn($r) => [
                '@type'        => 'Review',
                'author'       => ['@type' => 'Person', 'name' => $r['author'] ?? 'Покупатель'],
                'reviewRating' => ['@type' => 'Rating', 'ratingValue' => (string)($r['rating'] ?? 5), 'bestRating' => '5', 'worstRating' => '1'],
                'reviewBody'   => $r['text'] ?? '',
                'datePublished'=> $r['created_at'] ?? date('Y-m-d'),
            ], array_slice($reviews, 0, 5));
        }

        return $schema;
    }

    private function schemaBreadcrumbs(array $items): array
    {
        return [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => array_values(array_map(fn($item, $i) => [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => $item['name'],
                'item'     => APP_URL . $item['url'],
            ], $items, array_keys($items))),
        ];
    }

    private function schemaItemList(array $products): array
    {
        return [
            '@context'        => 'https://schema.org',
            '@type'           => 'ItemList',
            'name'            => 'Каталог пробиотических средств Chrisal',
            'itemListElement' => array_values(array_map(fn($p, $i) => [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'url'      => APP_URL . '/catalog/' . $p['slug'],
                'name'     => $p['name'],
            ], array_slice($products, 0, 10), range(0, max(0, min(9, count($products) - 1))))),
        ];
    }

    private function schemaFaq(array $items): array
    {
        return [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => array_map(fn($item) => [
                '@type'          => 'Question',
                'name'           => $item['q'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['a']],
            ], $items),
        ];
    }

    private function addSchema(array $schema): void
    {
        $this->schemas[] = $schema;
    }
}
