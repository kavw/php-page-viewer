<?php

declare(strict_types=1);

namespace PV\Infra\DBAL\Mysql;

use PDO;
use Psr\Log\LoggerInterface;
use PV\Infra\DBAL\ConnectionInterface;
use PV\Infra\DBAL\Context;
use PV\Infra\DBAL\QueryInterface;
use PV\Infra\Hydrator\HydratorInterface;
use PV\Infra\Secret\SecretProviderInterface;

final class Connection implements ConnectionInterface
{
    private ?PDO $conn = null;

    public function __construct(
        readonly private SecretProviderInterface $sp,
        readonly private HydratorInterface $hydrator,
        readonly private ?LoggerInterface $logger = null,
    ) {
    }

    public function query(callable $cb): QueryInterface
    {
        $context = new Context();
        $queryString = [];
        foreach ($cb($context) as $str) {
            $queryString[] = $str;
        }

        return new Query(
            $this->getConnection(),
            implode(' ', $queryString),
            $context,
            $this->hydrator,
            $this->logger
        );
    }

    private function getConnection(): PDO
    {
        if ($this->conn) {
            return $this->conn;
        }

        $dsn = sprintf(
            'mysql:host=%s:%s;dbname=%s',
            $this->sp->get('MYSQL_HOST'),
            $this->sp->get('MYSQL_PORT'),
            $this->sp->get('MYSQL_DATABASE'),
        );

        $this->logger?->debug("Connecting to {$dsn}");

        return $this->conn = new PDO(
            $dsn,
            $this->sp->get('MYSQL_USERNAME'),
            $this->sp->get('MYSQL_PASSWORD')
        );
    }
}
