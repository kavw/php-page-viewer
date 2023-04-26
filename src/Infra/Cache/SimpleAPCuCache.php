<?php

declare(strict_types=1);

namespace PV\Infra\Cache;

use DateInterval;
use Psr\SimpleCache\CacheInterface;

final class SimpleAPCuCache implements CacheInterface
{
    private string $prefix;

    public function __construct(string $namespace)
    {
        $this->prefix = self::class . ':' . $namespace . ':';
    }

    /**
     * @inheritdoc
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $key = $this->wrap($key);
        $result = \apcu_fetch($key, $success);
        if (!$success) {
            return $default;
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function set(string $key, mixed $value, DateInterval|int|null $ttl = null): bool
    {
        $key = $this->wrap($key);
        if ($ttl instanceof DateInterval) {
            $ttl = $ttl->s;
        } elseif ($ttl === null) {
            $ttl = 0;
        }

        return \apcu_store($key, $value, $ttl);
    }

    /**
     * @inheritdoc
     */
    public function delete(string $key): bool
    {
        $key = $this->wrap($key);
        return (bool) \apcu_delete($key);
    }

    /**
     * @inheritdoc
     */
    public function clear(): bool
    {
        return \apcu_clear_cache();
    }

    /**
     * @inheritdoc
     */
    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        $data = [];
        foreach ($keys as $k) {
            $data[] = $this->wrap($k);
        }

        $result = \apcu_fetch($data, $success);
        if (!$success || !is_array($result)) {
            return $default;
        }

        foreach ($result as $k => $v) {
            yield $k => $v;
        }
    }

    /**
     * @inheritdoc
     * @param      iterable<string, mixed> $values
     */
    public function setMultiple(iterable $values, DateInterval|int|null $ttl = null): bool
    {
        if ($ttl instanceof DateInterval) {
            $ttl = $ttl->s;
        } elseif ($ttl === null) {
            $ttl = 0;
        }

        $data = [];
        foreach ($values as $k => $v) {
            $data[$this->wrap($k)] = $v;
        }

        $result = \apcu_store($data, null, $ttl);
        if (!is_array($result)) {
            return $result;
        }

        return (bool) array_filter($result);
    }

    /**
     * @inheritdoc
     */
    public function deleteMultiple(iterable $keys): bool
    {
        $data = [];
        foreach ($keys as $k) {
            $data[] = $this->wrap($k);
        }

        $result = \apcu_delete($data);
        if (!is_array($result)) {
            return $result;
        }

        return (bool) array_filter($result);
    }

    /**
     * @inheritdoc
     */
    public function has(string $key): bool
    {
        return (bool) \apcu_exists($key);
    }

    private function wrap(string $key): string
    {
        return $this->prefix . $key;
    }
}
