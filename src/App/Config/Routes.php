<?php

declare(strict_types=1);

namespace App\Config;

use App\Controllers\AboutController;
use App\Controllers\AuthController;
use App\Controllers\ErrorController;
use App\Controllers\HomeController;
use App\Controllers\ReceiptController;
use App\Controllers\TransactionController;
use App\Middleware\AuthenticatedMiddleware;
use App\Middleware\GuestMiddleware;
use Framework\App;

class Routes
{
    public static function addRoutes(App $app): void
    {
        $app->get('/', [HomeController::class, 'index'])->addRouteMiddleware(AuthenticatedMiddleware::class);
        $app->get('/about', [AboutController::class, 'index']);
        $app->get('/register', [AuthController::class, 'registerPage'])->addRouteMiddleware(GuestMiddleware::class);
        $app->post('/register', [AuthController::class, 'register'])->addRouteMiddleware(GuestMiddleware::class);
        $app->get('/login', [AuthController::class, 'loginPage'])->addRouteMiddleware(GuestMiddleware::class);
        $app->post('/login', [AuthController::class, 'login'])->addRouteMiddleware(GuestMiddleware::class);
        $app->post('/logout', [AuthController::class, 'logout'])->addRouteMiddleware(AuthenticatedMiddleware::class);

        $app->get('/transactions/create', [TransactionController::class, 'create'])->addRouteMiddleware(
            AuthenticatedMiddleware::class
        );
        $app->post('/transactions/create', [TransactionController::class, 'store'])->addRouteMiddleware(
            AuthenticatedMiddleware::class
        );
        $app->get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->addRouteMiddleware(
            AuthenticatedMiddleware::class
        );
        $app->put('/transactions/{transaction}/edit', [TransactionController::class, 'update'])->addRouteMiddleware(
            AuthenticatedMiddleware::class
        );
        $app->delete('/transactions/{transaction}', [TransactionController::class, 'delete'])->addRouteMiddleware(
            AuthenticatedMiddleware::class
        );
        $app->get('/transactions/{transaction}/receipt', [ReceiptController::class, 'create']
        )->addRouteMiddleware(
            AuthenticatedMiddleware::class
        );
        $app->post('/transactions/{transaction}/receipt', [ReceiptController::class, 'store']
        )->addRouteMiddleware(
            AuthenticatedMiddleware::class
        );
        $app->get('/transactions/{transaction}/receipt/{receipt}', [ReceiptController::class, 'getReceipt']
        )->addRouteMiddleware(
            AuthenticatedMiddleware::class
        );
        $app->delete('/transactions/{transaction}/receipt/{receipt}', [ReceiptController::class, 'delete']
        )->addRouteMiddleware(
            AuthenticatedMiddleware::class
        );

        $app->setErrorHandler([ErrorController::class, 'notFound']);
    }
}