<?php

declare(strict_types=1);

namespace PV\Infra\Http\Server\Middleware;

use PV\Infra\Http\Server\Request\SimpleRequestInterface;
use PV\Infra\Http\Server\Response\SimpleResponseInterface;

interface HttpMiddlewareInterface
{
    public function __invoke(
        SimpleRequestInterface $request,
        HttpMainMiddlewareInterface|HttpMiddlewareInterface $next
    ): SimpleResponseInterface;
}
