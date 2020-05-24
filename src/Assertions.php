<?php

namespace RemotelyLiving\PHPEnv;

use RemotelyLiving\PHPEnv\Exceptions;

final class Assertions
{
    public static function assertNotEmptyString($value): void
    {
        if (!is_string($value) || $value === '') {
            throw Exceptions\InvalidArgument::isEmpty();
        }
    }

    public static function assertNumeric($value): void
    {
        if (!is_numeric($value)) {
            throw Exceptions\InvalidArgument::invalidNumeric($value);
        }
    }

    public static function assertObject($value): void
    {
        if (!is_object($value)) {
            throw Exceptions\InvalidArgument::invalidObject($value);
        }
    }

    public static function assertBoolish($value): void
    {
        $normalizedValue = \mb_strtolower((string) $value);
        if ($normalizedValue === 'false' || $normalizedValue === 'true') {
            return;
        }

        if ($value === '1' || $value === '0') {
            return;
        }

        throw Exceptions\InvalidArgument::invalidBooleanValue($value);
    }
}
