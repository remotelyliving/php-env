[![Build Status](https://travis-ci.com/remotelyliving/php-env.svg?branch=master)](https://travis-ci.org/remotelyliving/php-env)
[![Total Downloads](https://poser.pugx.org/remotelyliving/php-env/downloads)](https://packagist.org/packages/remotelyliving/php-env)
[![Coverage Status](https://coveralls.io/repos/github/remotelyliving/php-env/badge.svg?branch=master)](https://coveralls.io/github/remotelyliving/php-env?branch=master) 
[![License](https://poser.pugx.org/remotelyliving/php-env/license)](https://packagist.org/packages/remotelyliving/php-env)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/remotelyliving/php-env/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/remotelyliving/php-env/?branch=master)

# php-env
### 🌎 An Environment Abstraction for PHP 🌎

### Use Cases

If you want a boundary between you and your runtime environment, this library can help.
If you like to use .env files this library can help.

### Installation

```sh
composer require remotelyliving/php-env
```

### Usage

#### Create The Application Environment

```php
<?php
// needs to be set before hand through docker or could grab the app environment from cli args
// EnvironmentType is an enum that you can extend to add more values to
$envType = new EnvironmentType(getenv('ENVIRONMENT'));
$envFile = "/my/app/envs/.{$envType}.env";

// we can now create the app environment
$env = Environment::createWithEnvFile($envType, $envFile);

// tells you which environment you're in
$env->is(EnvironmentType::DEVELOPMENT()); // true
$env->is(EnvironmentType::PRODUCTION()); // false

// tells you if a var exists
$env->has('FOO'); // true

// returns a value caster of a value that can then be called to get stricter types 
$env->get('FOO')->asArray();
$env->get('BAR')->asBoolean();
$env->get('BAR')->asInteger();
```