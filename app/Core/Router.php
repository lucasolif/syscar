<?php

namespace App\Core;

class Router{
    private array $routes = [];

    public function get(string $uri, array $action): void{
        $this->routes['GET'][] = [
            'uri' => $uri,
            'action' => $action
        ];
    }
    public function post(string $uri, array $action): void{
        $this->routes['POST'][] = [
            'uri' => $uri,
            'action' => $action
        ];
    }
    public function dispatch(): void{
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rtrim($uri, '/') ?: '/';

        foreach ($this->routes[$method] ?? [] as $route) {
            $pattern = preg_replace('/\{[a-zA-Z]+\}/', '([0-9]+)', $route['uri']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);

                [$controllerClass, $methodName] = $route['action'];

                $controller = new $controllerClass();

                call_user_func_array([$controller, $methodName], $matches);
                return;
            }
        }

        http_response_code(404);
        echo "Página não encontrada.";
    }
}