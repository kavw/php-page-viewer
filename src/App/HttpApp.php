<?php

declare(strict_types=1);

namespace PV\App;

use PV\App\Container\Container;
use PV\Infra\Http\Server\Middleware\HttpMiddlewareChainInterface;

final class HttpApp extends AbstractApp
{
    /**
     * @param  Settings      $settings
     * @param  resource|null $logStream
     * @return static
     */
    public static function create(
        Settings $settings = new Settings(),
        $logStream = null
    ): self {
        $container = new Container($settings, $logStream);
        return new HttpApp($container);
    }

    public function boot(): HttpMiddlewareChainInterface
    {
        $chainFactory = $this->container->getHttpMiddlewareChainFactory();
        $chain = $chainFactory->create($this->container->getRequestHandlerMiddleware());

        $chain->push($this->container->getUserAwareExceptionHandlerMiddleware());
        $chain->push($this->container->getFrontCacheMiddleware());
        $chain->push($this->container->getProfilingMiddleware());

        return $chain;
    }

    protected function main(): void
    {
        $chain = $this->boot();

        $req = $this->container->getRequestFactory()->createFromGlobals();
        $resp = $chain->run($req);
        $resp->send();
    }
}
