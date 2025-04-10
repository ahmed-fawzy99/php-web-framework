<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;

class Controller
{
    public function __construct(
        protected TemplateEngine $templateEngine,
    ) {
    }
}