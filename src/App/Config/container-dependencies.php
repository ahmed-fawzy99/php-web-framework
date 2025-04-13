<?php

declare(strict_types=1);

use App\Config\Path;
use App\Services\ReceiptService;
use App\Services\TransactionService;
use App\Services\UserService;
use App\Services\ValidationService;
use Framework\Container;
use Framework\Database;
use Framework\TemplateEngine;

return [
    TemplateEngine::class => fn() => new TemplateEngine(Path::VIEWS),
    ValidationService::class => fn() => new ValidationService(),
    Database::class => fn() => new Database(
        'mysql',
        [
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'dbname' => $_ENV['DB_DATABASE']
        ],
        $_ENV['DB_USERNAME'],
        $_ENV['DB_PASSWORD']
    ),
    UserService::class => function (Container $container) {
        return new UserService(
            $container->get(Database::class)
        );
    },
    TransactionService::class => function (Container $container) {
        return new TransactionService(
            $container->get(Database::class)
        );
    },
    ReceiptService::class => function (Container $container) {
        return new ReceiptService(
            $container->get(Database::class)
        );
    },
];