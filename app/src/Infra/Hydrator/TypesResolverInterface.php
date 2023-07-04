<?php

declare(strict_types=1);

namespace PV\Infra\Hydrator;

interface TypesResolverInterface
{
    public function resolve(string $type, string $val): mixed;

    public function addResolver(TypeResolverInterface $resolver): void;
}
