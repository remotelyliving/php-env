<?php

declare(strict_types=1);

namespace RemotelyLiving\PHPEnv\Interfaces;

interface Marshaller
{
    public function marshallIntoEnvironment(): void;
}
