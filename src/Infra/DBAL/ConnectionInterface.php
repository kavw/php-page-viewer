<?php

declare(strict_types=1);

namespace PV\Infra\DBAL;

interface ConnectionInterface
{
    /**
     * @param callable(ContextInterface): iterable<string> $cb
     */
    public function query(callable $cb): QueryInterface;
}
