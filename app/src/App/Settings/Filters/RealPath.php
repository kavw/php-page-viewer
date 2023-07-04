<?php

declare(strict_types=1);

namespace PV\App\Settings\Filters;

final class RealPath
{
    public function __invoke(string $val): string
    {
        return realpath($val)
            ?: throw new \InvalidArgumentException(
                "Can't resolve real path for value '$val'"
            );
    }
}
