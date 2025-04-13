<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array $routes = [];
    private array $middlewares = [];
    private array $errorHandler;

    public function add(string $method, string $path, array $controller): void
    {
        $path = $this->normalizePath($path);

        $regexPath = preg_replace(
            '#{[^/]+}#',
            '([^/]+)',
            $path
        );
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'controller' => $controller,
            'middlewares' => [],
            'regexPath' => $regexPath,
        ];
    }

    /**
     * @throws \ReflectionException
     */
    public function dispatch(string $path, string $method, Container $container = null): void
    {
        $method = strtoupper($_POST['_METHOD'] ?? $method);
        $path = $this->normalizePath($path);

        foreach ($this->routes as $route) {
            if (!preg_match("#^{$route['regexPath']}$#", $path, $paramValues) || $method !== $route['method']) {
                continue;
            }

            // Resolve Route Parameters
            array_shift($paramValues);

            preg_match_all(
                '#{([^/]+)}#',
                $route['path'],
                $paramsKeys
            );

            $params = array_combine($paramsKeys[1], $paramValues);

            [$class, $fn] = $route['controller'];

            if (!class_exists($class)) {
                throw new \RuntimeException("Class $class not found");
            }

            if (!method_exists($class, $fn)) {
                throw new \RuntimeException("Method $fn not found in class $class");
            }


            // Resolve the class instance using the container
            $classInstance = $container ? $container->resolve($class) : new $class;
            $action = fn() => $classInstance->{$fn}($params);

            $allMiddlewares = [...$route['middlewares'], ...$this->middlewares];

            foreach ($allMiddlewares as $middleware) {
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

        $this->dispatchNotFound($container);
    }

    public function addMiddleware(string $className): void
    {
        $this->middlewares[] = $className;
    }

    public function addRouteMiddleware(string $middlewareClass): void
    {
        $this->routes[array_key_last($this->routes)]['middlewares'][] = $middlewareClass;
    }

    public function setErrorHandler(array $controller)
    {
        $this->errorHandler = $controller;
    }

    public function dispatchNotFound(?Container $container)
    {
        [$class, $function] = $this->errorHandler;

        $controllerInstance = $container ? $container->resolve($class) : new $class;

        $action = fn() => $controllerInstance->$function();

        foreach ($this->middlewares as $middleware) {
            $middlewareInstance = $container ? $container->resolve($middleware) : new $middleware;
            $action = fn() => $middlewareInstance->handle($action);
        }

        $action();
    }


    private function normalizePath(string $path): string
    {
        $path = '/' . trim($path, '/') . '/';
        return str_replace('//', '/', $path);
    }

}