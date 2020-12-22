<?php

declare(strict_types=1);

namespace Bengo4\Bearavel;

use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ray\Di\Di\Named;
use function tap;

final class Laravel implements BootstrapInterface
{
    /**
     * @var string
     */
    private $baseDir;

    /**
     * @Named("baseDir=laravel_base_dir")
     */
    public function __construct(string $baseDir)
    {
        $this->baseDir = $baseDir;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(string $context, array $globals, array $server): int
    {
        $app = new Application(
            $this->baseDir
        );

        $app->singleton(
            Kernel::class,
            \App\Http\Kernel::class
        );

        $app->singleton(
            ExceptionHandler::class,
            Handler::class
        );

        $kernel = $app->make(Kernel::class);

        $response = tap($kernel->handle(
            $request = Request::capture()
        ))->send();

        assert($response instanceof Response);
        $kernel->terminate($request, $response);

        if ($response->isOk() || $response->isRedirect()) {
            return 0;
        }

        return 1;
    }
}
