<?php
class AdminProductsController extends AdminBaseController
{
    public function index(): void
    {
        $this->requireAdmin();
        $this->render('products', [
            'title'    => 'Товары — Админ',
            'products' => (new Product())->all(),
            'stats'    => $this->stats(),
            'ok'       => flashGet('ok'),
        ]);
    }

    public function create(): void
    {
        $this->requireAdmin();
        $categories = json_decode(file_get_contents(DATA_CATEGORIES), true) ?? [];
        $this->render('product_form', [
            'title'      => 'Новый товар — Админ',
            'product'    => null,
            'categories' => $categories,
            'stats'      => $this->stats(),
            'error'      => flashGet('error'),
        ]);
    }

    public function store(): void
    {
        $this->requireAdmin();
        if (!csrfVerify()) { flashSet('error', 'CSRF'); header('Location: /admin/products/create'); exit; }

        $name = trim($_POST['name'] ?? '');
        if (!$name) { flashSet('error', 'Название обязательно'); header('Location: /admin/products/create'); exit; }

        $product = $this->buildProductFromPost();
        $product['id']         = 'PROD-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
        $product['slug']       = slug($name) ?: $product['id'];
        $product['created_at'] = date('Y-m-d');

        (new Product())->save($product);
        flashSet('ok', 'Товар «' . $name . '» добавлен');
        header('Location: /admin/products'); exit;
    }

    public function edit(array $params): void
    {
        $this->requireAdmin();
        $product = (new Product())->findById($params['id']);
        if (!$product) { http_response_code(404); echo 'Не найдено'; return; }

        $categories = json_decode(file_get_contents(DATA_CATEGORIES), true) ?? [];
        $this->render('product_form', [
            'title'      => 'Редактировать — Админ',
            'product'    => $product,
            'categories' => $categories,
            'stats'      => $this->stats(),
            'error'      => flashGet('error'),
        ]);
    }

    public function update(array $params): void
    {
        $this->requireAdmin();
        if (!csrfVerify()) { flashSet('error', 'CSRF'); header('Location: /admin/products/' . $params['id'] . '/edit'); exit; }

        $product = (new Product())->findById($params['id']);
        if (!$product) { http_response_code(404); return; }

        $updated = array_merge($product, $this->buildProductFromPost());
        (new Product())->save($updated);

        flashSet('ok', 'Товар обновлён');
        header('Location: /admin/products'); exit;
    }

    public function toggleStock(array $params): void
    {
        $this->requireAdmin();
        if (!csrfVerify()) { $this->renderJson(['error' => 'CSRF'], 403); }

        $model   = new Product();
        $product = $model->findById($params['id']);
        if (!$product) { $this->renderJson(['error' => 'Not found'], 404); }

        $product['in_stock'] = !$product['in_stock'];
        $model->save($product);
        $this->renderJson(['in_stock' => $product['in_stock'], 'ok' => true]);
    }

    // ——— Вспомогательный метод ———
    private function buildProductFromPost(): array
    {
        $audience = [];
        if (!empty($_POST['audience_private']))  $audience[] = 'private';
        if (!empty($_POST['audience_business'])) $audience[] = 'business';

        return [
            'name'           => trim($_POST['name']        ?? ''),
            'short_desc'     => trim($_POST['short_desc']  ?? ''),
            'description'    => trim($_POST['description'] ?? ''),
            'price'          => (float)($_POST['price']    ?? 0),
            'price_old'      => (float)($_POST['price_old']?? 0),
            'volume'         => (int)($_POST['volume']     ?? 0),
            'unit'           => trim($_POST['unit']        ?? 'мл'),
            'brand'          => trim($_POST['brand']       ?? 'Chrisal'),
            'category'       => trim($_POST['category']    ?? ''),
            'type'           => trim($_POST['type']        ?? ''),
            'audience'       => $audience,
            'in_stock'       => !empty($_POST['in_stock']),
            'stock_fbs'      => (int)($_POST['stock_fbs']  ?? 0),
            'badge'          => trim($_POST['badge']       ?? ''),
            'features'       => array_values(array_filter(
                array_map('trim', explode("\n", $_POST['features'] ?? ''))
            )),
            'image'          => trim($_POST['image']       ?? ''),
        ];
    }
}
