<?php

declare(strict_types=1);

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
