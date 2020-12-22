<?php

declare(strict_types=1);

namespace Bengo4\Bearavel;

use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

class Dispatcher implements DispatcherInterface
{
    /** @var string[] */
    private $route = [
        '/',
    ];

    /**
     * @var BootstrapInterface
     */
    private $primary;

    /**
     * @var BootstrapInterface
     */
    private $secondary;

    /**
     * @Inject
     * @Named("primary=primary")
     */
    public function __construct(BootstrapInterface $primary, BootstrapInterface $secondary)
    {
        $this->primary = $primary;
        $this->secondary = $secondary;
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(string $context, array $globals, array $server): int
    {
        $path = parse_url($server['REQUEST_URI'], PHP_URL_PATH);

        if (in_array($path, $this->route, true)) {
            return ($this->primary)($context, $globals, $server);
        }

        return ($this->secondary)($context, $globals, $server);
    }
}
