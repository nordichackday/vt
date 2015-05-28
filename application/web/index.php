<?php

use VT\Application;

require_once __DIR__.'/../vendor/autoload.php';

$env = getenv('SYMFONY_ENV') ?: 'dev';

$application = new Application(__DIR__.'/../', $env, in_array($env, ['dev']));
$application->run();