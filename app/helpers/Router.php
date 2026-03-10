<?php
class Router
{
    private array $routes = [];

    public function add(string $method, string $path, callable $handler): void
    {
        $this->routes[] = [$method, trim($path, '/'), $handler];
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = trim(parse_url($uri, PHP_URL_PATH), '/');
        $base = trim(parse_url(App::$config['app']['url'], PHP_URL_PATH) ?? '', '/');
        if ($base && str_starts_with($uri, $base)) {
            $uri = trim(substr($uri, strlen($base)), '/');
        }

        foreach ($this->routes as [$routeMethod, $routePath, $handler]) {
            $pattern = '#^' . preg_replace('/\{([a-z_]+)\}/', '([^/]+)', $routePath) . '$#';
            if ($routeMethod === $method && preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                $handler(...$matches);
                return;
            }
        }

        http_response_code(404);
        App::view('partials/404');
    }
}
