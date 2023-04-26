<?php

declare(strict_types=1);

namespace PV\Infra\DBAL;

interface ContextInterface
{
    /**
     * @param  scalar ...$params
     * @return string
     */
    public function __invoke(...$params): string;

    /**
     * @return array<string, scalar|array<scalar>>
     */
    public function getParams(): array;
}
