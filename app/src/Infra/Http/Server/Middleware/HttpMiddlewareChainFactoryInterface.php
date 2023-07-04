<?php

declare(strict_types=1);

namespace PV\Infra\Http\Server\Middleware;

interface HttpMiddlewareChainFactoryInterface
{
    public function create(
        HttpMainMiddlewareInterface $middleware
    ): HttpMiddlewareChainInterface;
}
