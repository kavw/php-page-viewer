<?php

declare(strict_types=1);

namespace PV\Infra\Hydrator;

use PV\Infra\Hydrator\Exceptions\HydrateException;

final class TypesResolver implements TypesResolverInterface
{
    /**
     * @var array<string, TypeResolverInterface>
     */
    private array $resolvers = [];

    /**
     * @param TypeResolverInterface[] $resolvers
     */
    public function __construct(array $resolvers = [])
    {
        foreach ($resolvers as $resolver) {
            $this->resolvers[$resolver->supports()] = $resolver;
        }
    }

    /**
     * @param  string $type
     * @param  string $val
     * @return mixed
     * @throws \Exception
     */
    public function resolve(string $type, string $val): mixed
    {
        return match ($type) {
            'string' => $val,
            'int' => is_numeric($val)
                ? (int) $val
                : throw new HydrateException("Can't cast to int given value"),
            'float' => is_numeric($val)
                ? (float) $val
                : throw new HydrateException("Can't cast to int given value"),
            'bool' => (bool) $val,

            \DateTime::class => isset($this->resolvers[$type])
                ? $this->resolvers[$type]->resolve($val)
                : new \DateTime($val),

            \DateTimeImmutable::class => isset($this->resolvers[$type])
                ? $this->resolvers[$type]->resolve($val)
                : new \DateTimeImmutable($val),

            default => isset($this->resolvers[$type])
                ? $this->resolvers[$type]->resolve($val)
                : throw new HydrateException("Can't resolve type '$type'")
        };
    }

    public function addResolver(TypeResolverInterface $resolver): void
    {
        $this->resolvers[$resolver->supports()] = $resolver;
    }
}
