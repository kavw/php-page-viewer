<?php

declare(strict_types=1);

namespace PV\Infra\Http\Server\Middleware;

use Psr\Log\LoggerInterface;

final readonly class HttpMiddlewareChainFactory implements HttpMiddlewareChainFactoryInterface
{
    public function __construct(
        private ?LoggerInterface $logger = null
    ) {
    }

    public function create(HttpMainMiddlewareInterface $middleware): HttpMiddlewareChainInterface
    {
        return new HttpMiddlewareChain($middleware, $this->logger);
    }
}
