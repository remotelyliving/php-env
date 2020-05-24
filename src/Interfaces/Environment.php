<?php

declare(strict_types=1);

namespace RemotelyLiving\PHPEnv\Interfaces;

use RemotelyLiving\PHPEnv\EnvironmentType;

interface Environment
{

    public function is(EnvironmentType $environment): bool;

    public function has(string $key): bool;

    public function get(string $key): Caster;
}
