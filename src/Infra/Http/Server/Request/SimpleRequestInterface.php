<?php

declare(strict_types=1);

namespace PV\Infra\Http\Server\Request;

interface SimpleRequestInterface
{
    public function getPath(): string;

    public function replacePath(string $path): self;

    public function getQueryParam(string $name): ?string;

    /**
     * @return array<string, string>
     */
    public function getQueryParams(): array;
}
