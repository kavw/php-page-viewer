<?php

declare(strict_types=1);

namespace PV\Infra\Http\Server\Middleware;

use PV\Infra\Http\Server\Request\SimpleRequestInterface;
use PV\Infra\Http\Server\Response\SimpleResponseInterface;

interface HttpMiddlewareChainInterface
{
    public function push(HttpMiddlewareInterface $middleware): void;

    public function run(SimpleRequestInterface $req): SimpleResponseInterface;
}
