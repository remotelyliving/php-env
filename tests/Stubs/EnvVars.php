<?php

namespace RemotelyLiving\PHPEnv\Tests\Stubs;

final class EnvVars
{
    public const KEY_STRING = 'STRING';
    public const KEY_INT = 'INT';
    public const KEY_FLOAT = 'FLOAT';
    public const KEY_JSON = 'JSON';
    public const KEY_SERIALIZED = 'SERIALIZED';
    public const KEY_BOOLISH_TRUE = 'BOOLISH_TRUE';
    public const KEY_BOOLISH_FALSE = 'BOOLISH_FALSE';

    public static function getEmpty(): array
    {
        return [];
    }

    public static function getFilled(): array
    {
        return [
            self::KEY_STRING => 'a regular old string',
            self::KEY_INT => '100',
            self::KEY_FLOAT => '100.01',
            self::KEY_JSON => '{"foo":"bar"}',
            self::KEY_SERIALIZED => 'O:8:"stdClass":1:{s:3:"foo";s:3:"bar";}',
            self::KEY_BOOLISH_TRUE => 'true',
            self::KEY_BOOLISH_FALSE => 'false',
        ];
    }
}
