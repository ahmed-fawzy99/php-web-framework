<?php

declare(strict_types=1);

namespace Framework;

class TemplateEngine
{
    private string $basePath;
    private array $globalData = [];

    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    public function render(string $template, array $data = []): string|false
    {
        ob_start();
        extract($data, EXTR_SKIP);
        extract($this->globalData, EXTR_SKIP);
        include $this->resolve($template);
        return ob_get_clean();
    }

    public function resolve(string $template): string
    {
        return $this->basePath . '/' . $template;
    }


    public function addGlobalData(string $key, mixed $value): void
    {
        $this->globalData[$key] = $value;
    }
}