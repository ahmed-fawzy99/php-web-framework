<?php

declare(strict_types=1);

namespace App\Config;

use App\Middleware\CsrfGuardMiddleware;
use App\Middleware\CsrfTokenMiddleware;
use App\Middleware\FlashErrorsMiddleware;
use App\Middleware\SessionMiddleware;
use App\Middleware\TemplateDataMiddleware;
use App\Middleware\ValidationExceptionMiddleware;
use Framework\App;

class Middleware
{
    public static function addMiddleware(App $app): void
    {
        $app->addMiddleware(CsrfGuardMiddleware::class);
        $app->addMiddleware(CsrfTokenMiddleware::class);
        $app->addMiddleware(TemplateDataMiddleware::class);
        $app->addMiddleware(ValidationExceptionMiddleware::class);
        $app->addMiddleware(FlashErrorsMiddleware::class);
        $app->addMiddleware(SessionMiddleware::class);
    }
}