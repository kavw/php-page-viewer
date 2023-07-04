<?php

declare(strict_types=1);

namespace PV\App\Settings\Assertions;

final class UriPrefix
{
    public function __invoke(string $val): bool
    {
        return $val === '' || (str_starts_with($val, '/') && !str_ends_with($val, '/'));
    }
}
