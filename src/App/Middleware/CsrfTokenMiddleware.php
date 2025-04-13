<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\TemplateEngine;

class CsrfTokenMiddleware implements MiddlewareInterface
{
    public function __construct(
        private TemplateEngine $view
    ) {
    }

    public function handle(callable $next): void
    {
        $_SESSION['csrf_token'] = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
        $this->view->addGlobalData('csrfToken', $_SESSION['csrf_token']);

        $next();
    }
}