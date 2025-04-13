<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class DateRule implements RuleInterface
{
    public function validate(array $data, string $field, array $params): bool
    {
        $parseDate = \DateTime::createFromFormat($params[0], $data[$field]);

        if ($parseDate && $parseDate->format($params[0]) === $data[$field]) {
            return true;
        }
        return false;
    }

    public function getMessage(array $data, string $field, array $params): string
    {
        return "The field {$field} must be a valid date in the format {$params[0]}.";
    }
}
