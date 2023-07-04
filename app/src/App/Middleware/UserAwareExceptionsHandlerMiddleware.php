<?php

declare(strict_types=1);

namespace PV\App\Middleware;

use PV\App\Document\Routes\Home\HomeView;
use PV\App\Exceptions\NotFoundException;
use PV\Infra\Http\Server\Middleware\HttpMainMiddlewareInterface;
use PV\Infra\Http\Server\Middleware\HttpMiddlewareInterface;
use PV\Infra\Http\Server\Request\SimpleRequestInterface;
use PV\Infra\Http\Server\Response\Code;
use PV\Infra\Http\Server\Response\ResponseFactoryInterface;
use PV\Infra\Http\Server\Response\SimpleResponseInterface;
use PV\Infra\View\RendererFactoryInterface;
use PV\Infra\View\RenderInterface;

final readonly class UserAwareExceptionsHandlerMiddleware implements HttpMiddlewareInterface
{
    public function __construct(
        private RenderInterface $render,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function __invoke(
        SimpleRequestInterface $request,
        HttpMainMiddlewareInterface|HttpMiddlewareInterface $next
    ): SimpleResponseInterface {
        try {
            return $next($request);
        } catch (NotFoundException $e) {
            return $this->responseFactory->create(
                ($this->render)(
                    new HomeView(
                        message: $e->getMessage() ?: "Page '{$request->getPath()}' not found"
                    )
                ),
                Code::NOT_FOUND
            );
        }
    }
}
