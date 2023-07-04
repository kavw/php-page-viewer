<?php

declare(strict_types=1);

namespace PV\App\Settings;

final class EnvInt extends AbstractEnv
{
    public readonly int $val;

    /**
     * @param string          $name
     * @param int             $default
     * @param array<callable> $filters
     * @param array<callable> $assertions
     */
    public function __construct(
        string $name,
        int $default = 0,
        array $filters = [],
        array $assertions = [],
    ) {
        $val = (int) ($_ENV[$name] ?? $default);

        $this->val = $this->validate($val, $filters, $assertions);
    }
}
