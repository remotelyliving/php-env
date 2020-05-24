<?php

declare(strict_types=1);

namespace RemotelyLiving\PHPEnv\Interfaces;

interface Caster
{
    public function asString(): string;

    public function asInteger(): int;

    public function asFloat(): float;

    public function asBoolean(): bool;

    public function asArray(string $separator = ','): array;

    public function asUnserializedObject(): object;

    public function asJSONDecodedObject(): object;
}
