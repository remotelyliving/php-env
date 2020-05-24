<?php

declare(strict_types=1);

namespace RemotelyLiving\PHPEnv;

use RemotelyLiving\PHPEnv\Exceptions\InvalidArgument;

final class StringCaster implements Interfaces\Caster
{
    private string $string;

    private function __construct(string $string)
    {
        Assertions::assertNotEmptyString($string);
        $this->string = $string;
    }

    public static function cast(string $value): Interfaces\Caster
    {
        return new self($value);
    }

    public function asString(): string
    {
        return $this->string;
    }

    public function asInteger(): int
    {
        return (int) round($this->asFloat());
    }

    public function asFloat(): float
    {
        Assertions::assertNumeric($this->string);

        return $this->string * 1.0;
    }

    public function asBoolean(): bool
    {
        Assertions::assertBoolish($this->string);

        if (\mb_strtolower($this->string) === 'false') {
            return false;
        }

        return (bool) $this->string;
    }

    public function asArray(string $separator = ','): array
    {
        Assertions::assertNotEmptyString($separator);

        return explode($separator, $this->string);
    }

    public function asUnserializedObject(): object
    {
        try {
            $object = \unserialize($this->string);
        } catch (\Throwable $e) {
            throw InvalidArgument::unserializableValue($this->string, $e);
        }

        Assertions::assertObject($object);

        return $object;
    }

    public function asJSONDecodedObject(): object
    {
        $object = json_decode($this->string);

        Assertions::assertObject($object);

        return $object;
    }
}
