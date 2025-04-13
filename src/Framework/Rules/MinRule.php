<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class MinRule implements RuleInterface
{
    public function validate(array $data, string $field, array $params): bool
    {
        if (is_numeric($data[$field])) {
            return $data[$field] >= $params[0];
        } else {
            if (is_string($data[$field])) {
                return strlen($data[$field]) >= $params[0];
            }
        }
        return false;
    }

    public function getMessage(array $data, string $field, array $params): string
    {
        if (is_numeric($data[$field] ?? null)) {
            return "This field must be at least {$params[0]}.";
        }

        return "This field must be at least {$params[0]} characters long.";
    }
}
