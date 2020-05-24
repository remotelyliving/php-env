<?php

namespace RemotelyLiving\PHPEnv\Tests\Unit;

use RemotelyLiving\PHPEnv\Exceptions;
use RemotelyLiving\PHPEnv\StringCaster;

class StringCasterTest extends AbstractTestCase
{

    public function testCastsAsString(): void
    {
        $this->assertSame(
            'foobar',
            StringCaster::cast('foobar')->asString(),
        );
    }

    public function testCastsAsInteger(): void
    {
        $this->assertSame(
            2,
            StringCaster::cast('2')->asInteger(),
        );

        $this->assertSame(
            2,
            StringCaster::cast('2.1')->asInteger(),
        );

        $this->assertSame(
            3,
            StringCaster::cast('2.5')->asInteger(),
        );
    }

    /**
     * @dataProvider invalidNumericTypes
     */
    public function testDisallowsInvalidCastsAsInteger(string $invalidType): void
    {
        $this->expectException(Exceptions\InvalidArgument::class);
        StringCaster::cast($invalidType)->asInteger();
    }

    public function testCastsAsFloat(): void
    {
        $this->assertSame(
            2.0,
            StringCaster::cast('2')->asFloat(),
        );

        $this->assertSame(
            2.1769459034,
            StringCaster::cast('2.1769459034')->asFloat(),
        );
    }

    /**
     * @dataProvider invalidNumericTypes
     */
    public function testDisallowsInvalidCastsAsFloat(string $invalidType): void
    {
        $this->expectException(Exceptions\InvalidArgument::class);
        StringCaster::cast($invalidType)->asFloat();
    }

    public function testCastsAsBoolean(): void
    {
        $this->assertFalse(StringCaster::cast('false')->asBoolean());
        $this->assertFalse(StringCaster::cast('0')->asBoolean());

        $this->assertTrue(StringCaster::cast('true')->asBoolean());
        $this->assertTrue(StringCaster::cast('1')->asBoolean());
    }

    /**
     * @dataProvider invalidBooleanTypeProvider
     */
    public function testDisallowsInvalidCastsAsBoolean(string $invalidType): void
    {
        $this->expectException(Exceptions\InvalidArgument::class);
        StringCaster::cast($invalidType)->asBoolean();
    }

    public function testCastsAsJsonObject(): void
    {
        $this->assertEquals(
            new \stdClass(),
            StringCaster::cast('{}')->asJSONDecodedObject()
        );
    }

    /**
     * @dataProvider invalidJsonObjectTypeProvider
     */
    public function testDisallowsInvalidCastsAsJSONDecodedObject(string $invalidType): void
    {
        $this->expectException(Exceptions\InvalidArgument::class);
        StringCaster::cast($invalidType)->asJSONDecodedObject();
    }

    public function testCastsAsUnserializedObject(): void
    {
        $expected = new \stdClass();
        $expected->foo = 'bar';
        $this->assertEquals(
            $expected,
            StringCaster::cast('O:8:"stdClass":1:{s:3:"foo";s:3:"bar";}')->asUnserializedObject()
        );
    }

    /**
     * @dataProvider invalidSerializedObjectTypeProvider
     */
    public function testDisallowsInvalidCastsAsUnserializedObject(string $invalidType): void
    {
        $this->expectException(Exceptions\InvalidArgument::class);
        StringCaster::cast($invalidType)->asUnserializedObject();
    }

    public function testCastsSeparatedValuesAsArray(): void
    {
        $list1 = 'foo,bar,baz';
        $expectedList1 = ['foo', 'bar', 'baz'];
        $list2 = 'hey:you:all';
        $expectedList2 = ['hey', 'you', 'all'];
        $list3 = 'hey';
        $expectedList3 = ['hey'];

        $this->assertEquals(
            $expectedList1,
            StringCaster::cast($list1)->asArray()
        );

        $this->assertEquals(
            $expectedList2,
            StringCaster::cast($list2)->asArray(':')
        );

        $this->assertEquals(
            $expectedList3,
            StringCaster::cast($list3)->asArray(':')
        );
    }

    public function testDisallowsInvalidCastsAsArray(): void
    {
        $this->expectException(Exceptions\InvalidArgument::class);
        StringCaster::cast('hey there')->asArray('');
    }

    public function invalidBooleanTypeProvider(): array
    {
        return [
            'invalid string' => ['not valid boolean'],
            'invalid number' => ['300'],
            'invalid empty string' => ['']
        ];
    }

    public function invalidJsonObjectTypeProvider(): array
    {
        return [
            'invalid json' => ['not valid json'],
        ];
    }

    public function invalidSerializedObjectTypeProvider(): array
    {
        return [
            'invalid string' => ['not valid json'],
            'invalid array' => ['a:1:{s:3:"foo";s:3:"bar";}'],
            'invalid number' => ['s:1:"1";'],
            'invalid bool' => ['b:1;'],
        ];
    }

    public function invalidNumericTypes(): array
    {
        return [
            'invalid string' => ['not valid numeric'],
            'invalid bool' => ['true'],
        ];
    }
}
