<?php

declare(strict_types=1);

namespace PV\App\Settings;

abstract class AbstractEnv
{
    /**
     * @template T
     * @param    T               $val
     * @param    array<callable> $filters
     * @param    array<callable> $assertions
     * @return   T
     */
    protected function validate(
        mixed $val,
        array $filters = [],
        array $assertions = [],
    ): mixed {
        foreach ($filters as $filter) {
            $val = $filter($val);
        }

        foreach ($assertions as $assertion) {
            if ($assertion($val) === false) {
                $class = is_object($assertion) ? get_class($assertion) : '';
                throw new \InvalidArgumentException(
                    "Failed assertion {$class} for value: '$val'"
                );
            }
        }

        return $val;
    }
}
