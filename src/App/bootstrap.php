<?php

declare(strict_types=1);

require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/functions.php";

use App\Config\Middleware;
use App\Config\Path;
use App\Config\Routes;
use Framework\App;

$dotenv = Dotenv\Dotenv::createImmutable(Path::ROOT);
$dotenv->load();

$app = new App(Path::CONTAINER_DEFINITIONS);

Routes::addRoutes($app);
Middleware::addMiddleware($app);


return $app;