<?php

declare(strict_types=1);

namespace App\Config;

class Path
{
    public const string VIEWS = __DIR__ . '/../views';
    public const string CONTAINER_DEFINITIONS = __DIR__ . '/container-dependencies.php';
    public const string ROOT = __DIR__ . '/../../../';
    public const string UPLOADS_DIR = __DIR__ . '/../../../storage/uploads';
}