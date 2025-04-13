<?php

declare(strict_types=1);

namespace Framework;

class App
{
    private Router $router;
    private Container $container;

    public function __construct(string $containerDefinitionsPath = null)
    {
        $this->router = new Router();
        $this->container = new Container();

        if ($containerDefinitionsPath) {
            $this->container->addDefinitions(require $containerDefinitionsPath);
        }
    }

    public function run(): void
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        $this->router->dispatch($path, $method, $this->container);
    }

    public function get(string $path, array $controller): App
    {
        $this->router->add('GET', $path, $controller);
        return $this;
    }


    public function post(string $path, array $controller): App
    {
        $this->router->add('POST', $path, $controller);
        return $this;
    }

    public function put(string $path, array $controller): App
    {
        $this->router->add('PUT', $path, $controller);
        return $this;
    }

    public function delete(string $path, array $controller): App
    {
        $this->router->add('DELETE', $path, $controller);
        return $this;
    }

    public function addMiddleware(string $className): void
    {
        $this->router->addMiddleware($className);
    }

    public function addRouteMiddleware(string $className): void
    {
        $this->router->addRouteMiddleware($className);
    }

    public function setErrorHandler(array $controller): void
    {
        $this->router->setErrorHandler($controller);
    }
}