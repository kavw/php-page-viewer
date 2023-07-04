<?php

declare(strict_types=1);

namespace PV\Infra\DBAL;

interface ConnectionManagerInterface
{
    public function getReadableConnection(): ConnectionInterface;
}
