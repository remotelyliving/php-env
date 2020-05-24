<?php

declare(strict_types=1);

namespace RemotelyLiving\PHPEnv\Exceptions;

final class RuntimeError extends Exception
{
    private function __construct(string $message = "", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct(
            $message,
            $code,
            $previous
        );
    }

    public static function keyNotFound(string $key): self
    {
        return new static("{$key} does not exist in this environment");
    }

    public static function envFileNotFound(string $path): self
    {
        return new static("{$path} does not exist as a readable env file");
    }
}
