<?php

declare(strict_types=1);

namespace PV\Infra\DBAL;

interface ConnectionFactoryInterface
{
    public function create(): ConnectionInterface;
}
