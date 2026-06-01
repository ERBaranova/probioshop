<?php
class Router
{
    private array $routes = [];

    public function get(string $path, string $handler): void
    {
        $this->routes[] = ['GET', $path, $handler];
    }

    public function post(string $path, string $handler): void
    {
        $this->routes[] = ['POST', $path, $handler];
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri    = rtrim($uri, '/') ?: '/';

        foreach ($this->routes as [$routeMethod, $routePath, $handler]) {
            if ($routeMethod !== $method) continue;

            $pattern = $this->toRegex($routePath);
            if (preg_match($pattern, $uri, $matches)) {
                // Параметры из URL (например {slug})
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $this->call($handler, $params);
                return;
            }
        }

        $this->notFound();
    }

    private function toRegex(string $path): string
    {
        $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $path);
        return '#^' . $pattern . '$#';
    }

    private function call(string $handler, array $params): void
    {
        [$class, $method] = explode('@', $handler);
        $controller = new $class();
        // Передаём первый параметр как скалярный аргумент (если есть)
        if (!empty($params)) {
            $controller->$method(array_values($params)[0]);
        } else {
            $controller->$method();
        }
    }

    private function notFound(): void
    {
        http_response_code(404);
        $controller = new BaseController();
        $controller->render('pages/404', ['title' => 'Страница не найдена']);
    }
}
