<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\Exceptions\ValidationException;

class ValidationExceptionMiddleware implements MiddlewareInterface
{
    public function handle(callable $next): void
    {
        try {
            $next();
        } catch (ValidationException $exception) {
            $_SESSION['errors'] = $exception->errors;
            $_SESSION['oldFormData'] = array_diff_key(
                $_POST,
                array_flip(['password', 'confirmPassword'])
            );
            redirect($_SERVER['HTTP_REFERER']);
            exit;
        }
    }
}