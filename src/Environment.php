<?php

declare(strict_types=1);

namespace RemotelyLiving\PHPEnv;

use RemotelyLiving\PHPEnv\Marshallers;

final class Environment implements Interfaces\Environment
{
    private EnvironmentType $environmentType;

    private function __construct(EnvironmentType $environmentType)
    {
        $this->environmentType = $environmentType;
    }

    public static function create(EnvironmentType $environmentType, Interfaces\Marshaller $marshaller = null): self
    {
        if ($marshaller) {
            $marshaller->marshallIntoEnvironment();
        }

        return new self($environmentType);
    }

    public static function createWithEnvFile(EnvironmentType $environmentType, string $fullPath): self
    {
        return self::create($environmentType, Marshallers\EnvFile::createFromPath($fullPath));
    }

    public function is(EnvironmentType $environment): bool
    {
        return $this->environmentType->equals($environment);
    }

    public function has(string $key): bool
    {
        return \getenv($key) !== false;
    }

    /**
     * @psalm-suppress PossiblyFalseArgument
     */
    public function get(string $key): Interfaces\Caster
    {
        if ($this->has($key)) {
            return StringCaster::cast(\getenv($key));
        }

        throw Exceptions\RuntimeError::keyNotFound($key);
    }
}
