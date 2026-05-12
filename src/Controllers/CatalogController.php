<?php
class CatalogController extends BaseController
{
    public function index(): void
    {
        $productModel = new Product();

        $params = [
            'audience' => $_GET['audience'] ?? '',
            'category' => $_GET['category'] ?? '',
            'search'   => $_GET['q'] ?? '',
            'sort'     => $_GET['sort'] ?? 'default',
        ];

        $products   = $productModel->filter($params);
        $categories = json_decode(file_get_contents(DATA_CATEGORIES), true) ?? [];

        $this->render('pages/catalog', [
            'title'      => 'Каталог — ' . APP_NAME,
            'products'   => $products,
            'categories' => $categories,
            'params'     => $params,
        ]);
    }

    public function show(array $params): void
    {
        $productModel = new Product();
        $product = $productModel->findBySlug($params['slug']);

        if (!$product) {
            http_response_code(404);
            $this->render('pages/404', ['title' => 'Товар не найден']);
            return;
        }

        $reviews = [];
        if (file_exists(DATA_REVIEWS)) {
            $allReviews = json_decode(file_get_contents(DATA_REVIEWS), true) ?? [];
            $reviews = array_filter($allReviews, fn($r) => $r['product_id'] === $product['id']);
        }

        $this->render('pages/product', [
            'title'   => $product['name'] . ' — ' . APP_NAME,
            'product' => $product,
            'reviews' => array_values($reviews),
        ]);
    }
}
