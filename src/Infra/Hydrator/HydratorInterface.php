<?php

declare(strict_types=1);

namespace PV\Infra\Hydrator;

interface HydratorInterface
{
    /**
     * @template T of object
     * @param    class-string<T>            $class
     * @param    array<string, string|null> $from
     * @return   T
     */
    public function hydrate(string $class, array $from): object;
}
