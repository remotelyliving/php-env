<?php

namespace RemotelyLiving\PHPEnv\Tests\Unit;

use RemotelyLiving\PHPEnv\Environment;
use RemotelyLiving\PHPEnv\EnvironmentType;

class EnvironmentTest extends AbstractTestCase
{
    public function testKnowsWhichEnvironmentItIs(): void
    {
        $this->assertTrue(
            Environment::create(EnvironmentType::DEVELOPMENT())->is(EnvironmentType::DEVELOPMENT())
        );

        $this->assertTrue(
            Environment::create(EnvironmentType::STAGE())->is(EnvironmentType::STAGE())
        );

        $this->assertTrue(
            Environment::create(EnvironmentType::QA())->is(EnvironmentType::QA())
        );

        $this->assertTrue(
            Environment::create(EnvironmentType::PRODUCTION())->is(EnvironmentType::PRODUCTION())
        );
    }
}
