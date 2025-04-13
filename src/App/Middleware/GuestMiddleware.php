<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;

class GuestMiddleware implements MiddlewareInterface
{
    public function handle(callable $next): void
    {
        if (!empty($_SESSION['user'])) {
            redirect('/');
        }

        $next();
    }
}