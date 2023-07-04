<?php

declare(strict_types=1);

namespace PV\App\Settings\Assertions;

final class IsDir
{
    public function __invoke(string $val): bool
    {
        return is_dir($val);
    }
}
