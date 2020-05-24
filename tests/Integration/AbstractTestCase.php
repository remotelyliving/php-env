<?php

declare(strict_types=1);

namespace RemotelyLiving\PHPEnv\Tests\Integration;

use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    protected function registerEnvVars(array $envVars): void
    {
        foreach ($envVars as $key => $value) {
            \putenv("{$key}={$value}");
        }
    }

    protected function unregisterEnvVars(array $keys): void
    {
        foreach ($keys as $key) {
            \putenv($key);
        }
    }

    protected function getEnvFileStubPath(): string
    {
        return __DIR__ . '/../Stubs/.stub.env';
    }
}
