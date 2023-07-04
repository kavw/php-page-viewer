<?php

declare(strict_types=1);

namespace PV\Infra\DBAL;

interface QueryInterface
{
    /**
     * @template T of object
     * @param    class-string<T> $class
     * @return   T|null
     */
    public function hydrate(string $class): ?object;

    /**
     * @template T of object
     * @param    class-string<T> $class
     * @return   iterable<T>
     */
    public function hydrateAll(string $class): iterable;
}
