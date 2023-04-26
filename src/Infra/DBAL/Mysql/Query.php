<?php

declare(strict_types=1);

namespace PV\Infra\DBAL\Mysql;

use PDO;
use Psr\Log\LoggerInterface;
use PV\Infra\DBAL\ContextInterface;
use PV\Infra\DBAL\QueryInterface;
use PV\Infra\Hydrator\HydratorInterface;

final class Query implements QueryInterface
{
    /**
     * @var array<array<string, string>>|null
     */
    private ?array $result = null;

    public function __construct(
        readonly private PDO $conn,
        readonly private string $queryString,
        readonly private ContextInterface $ctx,
        readonly private HydratorInterface $hydrator,
        readonly private ?LoggerInterface $logger = null,
    ) {
    }

    /**
     * @inheritdoc
     */
    public function hydrate(string $class): ?object
    {
        $res = $this->exec();
        return isset($res[0]) ? $this->hydrator->hydrate($class, $res[0]) : null;
    }

    /**
     * @inheritdoc
     */
    public function hydrateAll(string $class): iterable
    {
        foreach ($this->exec() as $row) {
            yield $this->hydrator->hydrate($class, $row);
        }
    }

    /**
     * @return array<array<string, string>>
     */
    private function exec(): array
    {
        if ($this->result !== null) {
            return $this->result;
        }

        $stmt = $this->conn->prepare($this->queryString);
        $params = $this->ctx->getParams();

        $this->logger?->debug(
            $this->queryString,
            $params
        );

        foreach ($params as $k => $val) {
            $v = (is_array($val))
                ? implode(', ', array_map(fn ($i) => (string) $i, $val))
                : $val;

            $stmt->bindParam(
                $k,
                $v,
                match ($v) {
                    is_bool($v) => PDO::PARAM_BOOL,
                    is_int($v) => PDO::PARAM_INT,
                    is_null($v) => PDO::PARAM_NULL,
                    default => PDO::PARAM_STR
                }
            );
        }

        $result = $stmt->execute();
        if (!$result) {
            throw new \RuntimeException(implode(' ', $this->conn->errorInfo()));
        }

        return $this->result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
