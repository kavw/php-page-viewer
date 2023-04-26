<?php

declare(strict_types=1);

namespace PV\Infra\Http\Server\Request;

final readonly class SimpleRequest implements SimpleRequestInterface
{
    /**
     * @param string $path
     * @param array<string, string> $query
     */
    public function __construct(
        public string $path,
        public array $query = []
    ) {
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getQueryParam(string $name): ?string
    {
        return $this->query[$name] ?? null;
    }

    /**
     * @inheritdoc
     */
    public function getQueryParams(): array
    {
        return $this->query;
    }

    public function replacePath(string $path): self
    {
        return new self($path, $this->query);
    }
}
