<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class NumericRule implements RuleInterface
{
    public function validate(array $data, string $field, array $params): bool
    {
        return is_numeric($data[$field]);
    }

    public function getMessage(array $data, string $field, array $params): string
    {
        return "This field must be a number.";
    }
}
