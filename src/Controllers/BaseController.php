<?php
class BaseController
{
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        $viewFile = SRC . '/Views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            http_response_code(500);
            echo "Шаблон не найден: $view";
            return;
        }

        // Буферизуем контент страницы
        ob_start();
        include $viewFile;
        $content = ob_get_clean();

        // Рендерим в основной layout
        include SRC . '/Views/layouts/main.php';
    }

    protected function renderJson(mixed $data, int $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    protected function cartCount(): int
    {
        $cart = $_SESSION['cart'] ?? [];
        return array_sum(array_column($cart, 'qty'));
    }
}
