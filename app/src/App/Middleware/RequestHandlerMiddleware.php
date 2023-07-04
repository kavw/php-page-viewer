<?php

namespace PV\App\Middleware;

use PV\Infra\Http\Server\Middleware\HttpMainMiddlewareInterface;
use PV\Infra\Http\Server\Request\SimpleRequestInterface;
use PV\Infra\Http\Server\Response\ResponseFactoryInterface;
use PV\Infra\Http\Server\Response\SimpleResponseInterface;
use PV\Infra\Http\Server\Router\RouterInterface;

final readonly class RequestHandlerMiddleware implements HttpMainMiddlewareInterface
{
    public function __construct(
        private RouterInterface $router,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function __invoke(
        SimpleRequestInterface $request,
    ): SimpleResponseInterface {
        $res = $this->router->dispatch($request);
        if (is_string($res)) {
            return  $this->responseFactory->create($res);
        }

        return $res;
    }
}
