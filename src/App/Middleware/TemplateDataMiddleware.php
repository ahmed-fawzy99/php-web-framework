<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\TemplateEngine;

class TemplateDataMiddleware implements MiddlewareInterface
{
    public function __construct(
        private TemplateEngine $view,
    ) {
    }

    public function handle(callable $next): void
    {
        $this->view->addGlobalData('title', 'PHP Framework');
        $next();
    }
}