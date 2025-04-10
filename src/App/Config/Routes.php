<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;

class Routes
{
    public static function addRoutes(App $app): void
    {
        $app->get('/', [\App\Controllers\HomeController::class, 'index']);
        $app->get('/about', [\App\Controllers\AboutController::class, 'index']);
    }
}