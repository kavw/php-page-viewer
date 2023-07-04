<?php

declare(strict_types=1);

namespace PV\Infra\Hydrator;

use PV\Infra\Hydrator\Exceptions\HydrateException;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

final class SimpleHydrator implements HydratorInterface
{
    /**
     * @var array<string, array{params:ReflectionParameter[]}>
     */
    private array $ref = [];



    public function __construct(
        readonly private TypesResolverInterface $resolver = new TypesResolver(),
    ) {
    }

    /**
     * @inheritdoc
     * @throws     ReflectionException
     */
    public function hydrate(string $class, array $from, string $ctor = '__construct'): object
    {
        $params = [];
        foreach ($this->fetchReflection($class, $ctor) as $p) {
            $name = $p->getName();
            if (!array_key_exists($name, $from)) {
                if ($p->isDefaultValueAvailable()) {
                    $params[$name] = $p->getDefaultValue();
                    continue;
                }

                if ($p->allowsNull()) {
                    $params[$name] = null;
                    continue;
                }

                throw new HydrateException(
                    "There is no key '{$name}' in the \$from argument"
                );
            }

            if (!$p->hasType()) {
                $params[$name] = $from[$name];
                continue;
            }

            $type = $p->getType();
            /**
 * @var \ReflectionNamedType $type
*/
            $params[$name] = $this->resolver->resolve($type->getName(), $from[$name] ?? '');
        }

        return $ctor === '__construct'
            ? new $class(...$params)
            : $class::$ctor(...$params);
    }


    /**
     * @template T of object
     * @param    class-string<T> $class
     * @param    string          $ctor
     * @return   ReflectionParameter[]
     * @throws   ReflectionException
     */
    private function fetchReflection(string $class, string $ctor): array
    {
        $key = "$class.$ctor";
        if (!isset($this->ref[$key])) {
            $ref  = new ReflectionClass($class);
            $ctor = $ctor === '__construct'
                ? $ref->getConstructor()
                : $ref->getMethod($ctor);

            if (!$ctor) {
                throw new \RuntimeException(
                    "Can't get reflection for method '\$class::\$ctor'"
                );
            }

            $this->ref[$key]['params'] = $ctor->getParameters();
        }

        return $this->ref[$key]['params'];
    }
}
