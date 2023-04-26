<?php

declare(strict_types=1);

namespace PV\App\Settings\Assertions;

final class IsReadable
{
    public function __invoke(string $val): bool
    {
        return is_readable($val);
    }
}
