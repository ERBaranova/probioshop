<?php
class AdminBaseController
{
    protected function requireAdmin(): void
    {
        if (empty($_SESSION[SESSION_ADMIN_KEY])) {
            header('Location: /admin/login');
            exit;
        }
    }

    protected function render(string $view, array $data = []): void
    {
        extract($data);
        $viewFile = SRC . '/Views/admin/pages/' . $view . '.php';

        if (!file_exists($viewFile)) {
            http_response_code(500);
            echo "Шаблон не найден: $view";
            return;
        }

        ob_start();
        include $viewFile;
        $content = ob_get_clean();

        include SRC . '/Views/admin/layouts/admin.php';
    }

    protected function renderJson(mixed $data, int $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    protected function stats(): array
    {
        $orders   = (new Order())->all();
        $products = (new Product())->all();
        $users    = file_exists(DATA_USERS)
            ? json_decode(file_get_contents(DATA_USERS), true) ?? []
            : [];

        $newOrders = array_filter($orders, fn($o) => $o['status'] === 'new');
        $revenue   = array_sum(array_column(
            array_filter($orders, fn($o) => $o['status'] === 'done'),
            'total'
        ));

        return [
            'orders_total'  => count($orders),
            'orders_new'    => count($newOrders),
            'products_total'=> count($products),
            'users_total'   => count($users),
            'revenue'       => $revenue,
        ];
    }
}
