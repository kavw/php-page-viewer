<?php

declare(strict_types=1);

namespace PV\Infra\Http\Server\Request;

final class RequestFactory implements RequestFactoryInterface
{
    public function createFromGlobals(): SimpleRequestInterface
    {
        if (!isset($_SERVER['DOCUMENT_URI'])) {
            throw new \RuntimeException("Can't resolve uri");
        }

        return new SimpleRequest($_SERVER['DOCUMENT_URI'], $_GET);
    }

    public function create(string $path, array $queryParams = []): SimpleRequestInterface
    {
        return new SimpleRequest($path, $queryParams);
    }
}
