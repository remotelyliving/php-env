<?php

declare(strict_types=1);

namespace RemotelyLiving\PHPEnv\Exceptions;

final class InvalidArgument extends Exception
{
    private function __construct(string $message = "", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct(
            $message,
            $code,
            $previous
        );
    }

    public static function invalidBooleanValue($value): self
    {
        return new static(var_export($value, true) . ' is not boolish');
    }

    public static function isEmpty(): self
    {
        return new static('Value cannot be empty');
    }

    public static function invalidNumeric($value): self
    {
        return new static(var_export($value, true) . ' is not numeric');
    }

    public static function invalidObject($value): self
    {
        return new static(var_export($value, true) . ' is an valid object');
    }

    public static function unserializableValue($value, \Throwable $previous = null): self
    {
        return new static(var_export($value, true) . ' is unable to be serialized', 0, $previous);
    }
}
