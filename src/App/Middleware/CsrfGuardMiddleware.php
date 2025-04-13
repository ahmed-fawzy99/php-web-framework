<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;

class CsrfGuardMiddleware implements MiddlewareInterface
{

    public function handle(callable $next): void
    {
        $requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);

        if (!in_array($requestMethod, ['POST', 'PUT', 'DELETE'])) {
            $next();
            return;
        }

        if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
            redirect('/login');
        }

        unset($_SESSION['csrf_token']);
        $next();
    }
}