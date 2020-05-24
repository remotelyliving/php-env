<?php

declare(strict_types=1);

namespace RemotelyLiving\PHPEnv\Tests\Integration;

use RemotelyLiving\PHPEnv\Environment;
use RemotelyLiving\PHPEnv\EnvironmentType;
use RemotelyLiving\PHPEnv\Exceptions;
use RemotelyLiving\PHPEnv\Interfaces;
use RemotelyLiving\PHPEnv\Tests\Stubs;

class EnvironmentTest extends AbstractTestCase
{
    private Interfaces\Environment $env;

    protected function setUp(): void
    {
        $this->registerEnvVars(Stubs\EnvVars::getFilled());
        $this->env = Environment::create(EnvironmentType::DEVELOPMENT());

        parent::setUp();
    }

    protected function tearDown(): void
    {
        $this->unregisterEnvVars(Stubs\EnvVars::getFilled());
        parent::tearDown();
    }

    public function testGetsEnvVarsAsAMapper(): void
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

    public function testThrowsOnUnsetEnvVar(): void
    {
        $this->expectException(Exceptions\RuntimeError::class);
        $this->expectExceptionMessage('foo does not exist in this environment');
        $this->unregisterEnvVars(array_keys(Stubs\EnvVars::getFilled()));

        $this->env->get('foo');
    }

    public function testHasOrDoesNotHaveEnvVar(): void
    {
        $this->assertFalse($this->env->has('foo'));
        $this->assertTrue($this->env->has(Stubs\EnvVars::KEY_BOOLISH_FALSE));
    }
}
