<?php

declare(strict_types=1);

use Framework\Http;

function dd($val, $die = true)
{
    echo '<pre>';
    var_dump($val);
    echo '<pre />';

    if ($die) {
        die();
    }
}

function e(mixed $val): string
{
    return htmlspecialchars((string)$val);
}


function redirect(string $path): void
{
    header('Location: ' . $path);
    http_response_code(Http::REDIRECT_STATUS_CODE);
    exit;
}