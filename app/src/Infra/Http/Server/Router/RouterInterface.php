<?php

namespace PV\Infra\Http\Server\Router;

use PV\Infra\Http\Server\Request\SimpleRequestInterface;
use PV\Infra\Http\Server\Response\SimpleResponseInterface;

interface RouterInterface
{
    public function addRouteHandler(RouteHandlerInterface $handler): void;

    public function dispatch(SimpleRequestInterface $req): string|SimpleResponseInterface;

    /**
     * @param  string                $name
     * @param  array<string, scalar> $params
     * @return string
     */
    public function link(string $name, array $params = []): string;
}
