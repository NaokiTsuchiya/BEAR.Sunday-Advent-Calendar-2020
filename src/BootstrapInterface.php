<?php

declare(strict_types=1);

namespace Bengo4\Bearavel;

/**
 * @psalm-import-type Globals from \BEAR\Sunday\Extension\Router\RouterInterface
 * @psalm-import-type Server from \BEAR\Sunday\Extension\Router\RouterInterface
 */
interface BootstrapInterface
{
    /**
     * @psalm-param Globals $globals
     * @psalm-param Server  $server
     * @phpstan-param array<string, mixed> $globals
     * @phpstan-param array<string, mixed> $server
     *
     * @return 0|1
     */
    public function __invoke(string $context, array $globals, array $server): int;
}
