<?php

declare(strict_types=1);

namespace Bengo4\Bearavel;

use Ray\Di\AbstractModule;
use Ray\Di\Scope;

class DispatcherModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind()->annotatedWith('laravel_base_dir')->toInstance(__DIR__ . '/../laravel');
        $this->bind(BootstrapInterface::class)->to(Laravel::class)->in(Scope::SINGLETON);
        $this->bind(BootstrapInterface::class)->annotatedWith('primary')->to(Bootstrap::class)->in(Scope::SINGLETON);
        $this->bind(DispatcherInterface::class)->to(Dispatcher::class);
    }
}
