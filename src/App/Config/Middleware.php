<?php

declare(strict_types=1);

namespace App\Config;

use App\Middleware\TemplateDataMiddleware;
use Framework\App;

class Middleware
{
    public static function addMiddleware(App $app): void
    {
        $app->addMiddleware(TemplateDataMiddleware::class);
    }
}