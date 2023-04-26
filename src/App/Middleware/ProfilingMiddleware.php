<?php

namespace PV\App\Middleware;

;

use PV\Infra\Http\Server\Middleware\HttpMainMiddlewareInterface;
use PV\Infra\Http\Server\Middleware\HttpMiddlewareInterface;
use PV\Infra\Http\Server\Request\SimpleRequestInterface;
use PV\Infra\Http\Server\Response\ResponseFactoryInterface;
use PV\Infra\Http\Server\Response\SimpleResponseInterface;
use PV\Infra\Profiling\ProfilerInterface;

final readonly class ProfilingMiddleware implements HttpMiddlewareInterface
{
    public function __construct(
        private ProfilerInterface $profiler,
        private ResponseFactoryInterface $responseFactory
    ) {
    }

    public function __invoke(
        SimpleRequestInterface $request,
        HttpMainMiddlewareInterface|HttpMiddlewareInterface $next
    ): SimpleResponseInterface {
        $response = $next($request);

        $time = sprintf("%.3f", ($this->profiler->stop() / 1e+6));
        $text = "\n<!-- Generation time: {$time} ms -->";
        return $this->responseFactory->create(
            $response->getContent() . $text,
            $response->getCode(),
            $response->getHeaders() + ['X-PV-Prof' => "$time ms"]
        );
    }
}
