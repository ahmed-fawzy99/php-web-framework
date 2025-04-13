<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\TemplateEngine;

class FlashErrorsMiddleware implements MiddlewareInterface
{

    public function __construct(
        private TemplateEngine $view
    ) {
    }

    public function handle(callable $next): void
    {
        // Form Errors
        $this->view->addGlobalData('errors', $_SESSION['errors'] ?? []);
        unset($_SESSION['errors']);

        // Form Data
        $this->view->addGlobalData('oldFormData', $_SESSION['oldFormData'] ?? []);
        unset($_SESSION['oldFormData']);

        $next();
    }
}