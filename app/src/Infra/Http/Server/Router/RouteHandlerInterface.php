<?php

declare(strict_types=1);

namespace PV\Infra\Http\Server\Router;

use PV\Infra\Http\Server\Request\SimpleRequestInterface;
use PV\Infra\Http\Server\Response\SimpleResponseInterface;

interface RouteHandlerInterface
{
    public function getName(): string;

    public function match(SimpleRequestInterface $req): ?RouteHandlerInterface;

    /**
     * @param  array<string, string> $params
     * @return string
     */
    public function link(array $params = []): string;

    public function __invoke(SimpleRequestInterface $req): string|SimpleResponseInterface;
}
