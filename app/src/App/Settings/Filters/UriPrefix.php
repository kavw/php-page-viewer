<?php

declare(strict_types=1);

namespace PV\App\Settings\Filters;

final class UriPrefix
{
    public function __invoke(string $val): string
    {
        return $val === '/' ? '' : $val;
    }
}
