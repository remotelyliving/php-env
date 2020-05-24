<?php

declare(strict_types=1);

namespace RemotelyLiving\PHPEnv\Tests\Integration;

use RemotelyLiving\PHPEnv\Environment;
use RemotelyLiving\PHPEnv\EnvironmentType;
use RemotelyLiving\PHPEnv\Exceptions;
use RemotelyLiving\PHPEnv\Interfaces;
use RemotelyLiving\PHPEnv\Tests\Stubs;

class EnvironmentFileTest extends AbstractTestCase
{
    private Interfaces\Environment $env;

    protected function setUp(): void
    {
        clearstatcache();
        $this->env = Environment::createWithEnvFile(EnvironmentType::DEVELOPMENT(), $this->getEnvFileStubPath());

        parent::setUp();
    }

    protected function tearDown(): void
    {
        $this->unregisterEnvVars(array_keys(Stubs\EnvVars::getFilled()));
        parent::tearDown();
    }

    public function testMarshallsVarsFromEnvFile(): void
    {
        $expecteStdClass = new \stdClass();
        $expecteStdClass->foo = 'bar';

        $this->assertTrue($this->env->get(Stubs\EnvVars::KEY_BOOLISH_TRUE)->asBoolean());
        $this->assertFalse($this->env->get(Stubs\EnvVars::KEY_BOOLISH_FALSE)->asBoolean());
        $this->assertSame(100, $this->env->get(Stubs\EnvVars::KEY_INT)->asInteger());
        $this->assertSame(100.01, $this->env->get(Stubs\EnvVars::KEY_FLOAT)->asFloat());
        $this->assertEquals($expecteStdClass, $this->env->get(Stubs\EnvVars::KEY_SERIALIZED)->asUnserializedObject());
        $this->assertEquals($expecteStdClass, $this->env->get(Stubs\EnvVars::KEY_JSON)->asJSONDecodedObject());
    }

    public function testThrowsOnBadEnvFileLocation(): void
    {
        $this->expectException(Exceptions\RuntimeError::class);
        $this->expectExceptionMessage('foo.file does not exist as a readable env file');

        Environment::createWithEnvFile(EnvironmentType::DEVELOPMENT(), 'foo.file');
    }

    public function testHasOrDoesNotHaveEnvVar(): void
    {
        $this->assertFalse($this->env->has('foo'));
        $this->assertTrue($this->env->has(Stubs\EnvVars::KEY_BOOLISH_FALSE));
    }
}
