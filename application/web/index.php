<?php

use VT\Application;

require_once __DIR__.'/../vendor/autoload.php';

$env = getenv('SYMFONY_ENV') ?: 'prod';

$application = new Application(__DIR__.'/../', $env, in_array($env, ['dev']));
$application->run();