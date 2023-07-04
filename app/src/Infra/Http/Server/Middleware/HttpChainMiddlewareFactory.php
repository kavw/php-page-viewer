<?php

declare(strict_types=1);

namespace PV\Infra\Http\Server\Middleware;

final class HttpChainMiddlewareFactory implements HttpMiddlewareChainFactoryInterface
{
    public function create(HttpMainMiddlewareInterface $middleware): HttpMiddlewareChainInterface
    {
        return new HttpMiddlewareChain($middleware);
    }
}
