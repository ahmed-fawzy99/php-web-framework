<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class MatchesRule implements RuleInterface
{
    public function validate(array $data, string $field, array $params): bool
    {
        return $data[$field] === $params[0];
    }

    public function getMessage(array $data, string $field, array $params): string
    {
        return "This field must match {$params[0]}.";
    }
}
