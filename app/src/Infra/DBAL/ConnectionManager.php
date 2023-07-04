<?php

declare(strict_types=1);

namespace PV\Infra\DBAL;

use Psr\Log\LoggerInterface;
use PV\Infra\DBAL\Mysql\Connection;
use PV\Infra\Hydrator\HydratorInterface;
use PV\Infra\Secret\SecretProviderInterface;

final class ConnectionManager implements ConnectionManagerInterface
{
    private ?ConnectionInterface $connection = null;

    public function __construct(
        readonly private SecretProviderInterface $secretProvider,
        readonly private HydratorInterface $hydrator,
        readonly private ?LoggerInterface $logger = null,
    ) {
    }

    public function getReadableConnection(): ConnectionInterface
    {
        if ($this->connection) {
            return $this->connection;
        }

        return $this->connection = new Connection(
            $this->secretProvider,
            $this->hydrator,
            $this->logger
        );
    }
}
