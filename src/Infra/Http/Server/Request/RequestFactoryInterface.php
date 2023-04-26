<?php

declare(strict_types=1);

namespace PV\Infra\Http\Server\Request;

interface RequestFactoryInterface
{
    public function createFromGlobals(): SimpleRequestInterface;

    /**
     * @param  string                $path
     * @param  array<string, string> $queryParams
     * @return SimpleRequestInterface
     */
    public function create(string $path, array $queryParams = []): SimpleRequestInterface;
}
