<?php

declare(strict_types=1);

namespace PV\Infra\Hydrator;

interface TypeResolverInterface
{
    public function supports(): string;

    public function resolve(string $value): object;
}
