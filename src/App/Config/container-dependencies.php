<?php

declare(strict_types=1);

use App\Config\Path;
use Framework\TemplateEngine;

return [
    TemplateEngine::class => fn() => new TemplateEngine(Path::VIEWS),
];