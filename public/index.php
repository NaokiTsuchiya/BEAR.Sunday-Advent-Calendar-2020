<?php

declare(strict_types=1);

use Bengo4\Bearavel\Dispatcher;
use Bengo4\Bearavel\DispatcherInterface;
use Bengo4\Bearavel\DispatcherModule;
use Ray\Di\Injector;

require dirname(__DIR__) . '/autoload.php';

$injector = new Injector(new DispatcherModule());
$dispatcher = $injector->getInstance(DispatcherInterface::class);
assert($dispatcher instanceof Dispatcher);

exit($dispatcher(PHP_SAPI === 'cli-server' ? 'hal-app' : 'prod-hal-app', $GLOBALS, $_SERVER));
