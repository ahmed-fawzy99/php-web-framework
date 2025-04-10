<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array $routes = [];
    private array $middlewares = [];

    public function add(string $method, string $path, array $controller): void
    {
        $path = $this->normalizePath($path);

        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'controller' => $controller,
        ];
    }

    /**
     * @throws \ReflectionException
     */
    public function dispatch(string $path, string $method, Container $container = null): void
    {
        $method = strtoupper($method);
        $path = $this->normalizePath($path);

        foreach ($this->routes as $route) {
            if (!preg_match("#^{$route['path']}$#", $path) || $method !== $route['method']) {
                continue;
            }
            [$class, $fn] = $route['controller'];

            if (!class_exists($class)) {
                throw new \RuntimeException("Class $class not found");
            }

            if (!method_exists($class, $fn)) {
                throw new \RuntimeException("Method $fn not found in class $class");
            }

            // Resolve the class instance using the container

            $classInstance = $container ? $container->resolve($class) : new $class;
            $action = fn() => $classInstance->{$fn}();

            foreach ($this->middlewares as $middleware) {
                if (!class_exists($middleware)) {
                    throw new \RuntimeException("Middleware $middleware not found");
                }

                if (!method_exists($middleware, 'handle')) {
                    throw new \RuntimeException("Method handle not found in middleware $middleware");
                }

                $middlewareInstance = $container ? $container->resolve($middleware) : new $middleware;
                $action = fn() => $middlewareInstance->handle($action);
            }

            $action();

            return;
        }

        // If no route matches, return a 404 response
        http_response_code(404);
        echo "404 Not Found - Route not found";
    }

    public function addMiddleware(string $className): void
    {
        $this->middlewares[] = $className;
    }


    private function normalizePath(string $path): string
    {
        $path = '/' . trim($path, '/') . '/';
        return str_replace('//', '/', $path);
    }

}