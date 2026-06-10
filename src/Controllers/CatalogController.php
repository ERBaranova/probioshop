<?php
class CatalogController extends BaseController
{
    public function index(): void
    {
        $productModel = new Product();
        $params = [
            'audience' => $_GET['audience'] ?? '',
            'category' => $_GET['category'] ?? '',
            'q'        => $_GET['q'] ?? '',
            'sort'     => $_GET['sort'] ?? 'default',
        ];

        $products   = $productModel->filter($params);
        $categories = json_decode(file_get_contents(DATA_CATEGORIES), true) ?? [];
        $seo        = (new SeoHelper())->forCatalog($params, $categories, $products);

        $this->render('pages/catalog', [
            'seo'        => $seo,
            'title'      => $seo->getTitle(),
            'products'   => $products,
            'categories' => $categories,
            'params'     => $params,
        ]);
    }

    public function show(array $params): void
    {
        $product = (new Product())->findBySlug($params['slug']);

        if (!$product) {
            http_response_code(404);
            $seo = (new SeoHelper())->for404();
            $this->render('pages/404', ['seo' => $seo, 'title' => $seo->getTitle()]);
            return;
        }

        $reviews = [];
        if (file_exists(DATA_REVIEWS)) {
            $all     = json_decode(file_get_contents(DATA_REVIEWS), true) ?? [];
            $reviews = array_values(array_filter($all, fn($r) => $r['product_id'] === $product['id']));
        }

        $seo = (new SeoHelper())->forProduct($product, $reviews);

        $this->render('pages/product', [
            'seo'     => $seo,
            'title'   => $seo->getTitle(),
            'product' => $product,
            'reviews' => $reviews,
        ]);
    }
}
