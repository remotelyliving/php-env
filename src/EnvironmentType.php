<?php

declare(strict_types=1);

namespace RemotelyLiving\PHPEnv;

use MyCLabs\Enum\Enum;

/**
 * @psalm-immutable
 *
 * @method static \RemotelyLiving\PHPEnv\EnvironmentType DEVELOPMENT()
 * @method static \RemotelyLiving\PHPEnv\EnvironmentType STAGE()
 * @method static \RemotelyLiving\PHPEnv\EnvironmentType QA()
 * @method static \RemotelyLiving\PHPEnv\EnvironmentType PRODUCTION()
 */
class EnvironmentType extends Enum
{
    protected const DEVELOPMENT = 'development';
    protected const STAGE = 'stage';
    protected const QA = 'QA';
    protected const PRODUCTION = 'production';
}
