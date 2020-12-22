<?php

declare(strict_types=1);

namespace Bengo4\Bearavel;

use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Extension\Application\AppInterface;
use Bengo4\Bearavel\Module\App;
use Throwable;

use function assert;

final class Bootstrap implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(string $context, array $globals, array $server): int
    {
        $app = Injector::getInstance($context)->getInstance(AppInterface::class);
        assert($app instanceof App);
        if ($app->httpCache->isNotModified($server)) {
            $app->httpCache->transfer();

            return 0;
        }

        $request = $app->router->match($globals, $server);
        try {
            $response = $app->resource->{$request->method}->uri($request->path)($request->query);
            assert($response instanceof ResourceObject);
            $response->transfer($app->responder, $server);

            return 0;
        } catch (Throwable $e) {
            $app->throwableHandler->handle($e, $request)->transfer();

            return 1;
        }
    }
}
