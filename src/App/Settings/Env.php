<?php

declare(strict_types=1);

namespace PV\App\Settings;

final class Env extends AbstractEnv
{
    public readonly string $val;

    /**
     * @param string          $name
     * @param string          $default
     * @param array<callable> $filters
     * @param array<callable> $assertions
     */
    public function __construct(
        string $name,
        string $default = '',
        array $filters = [],
        array $assertions = [],
    ) {
        $val = trim($_ENV[$name] ?? $default);

        $this->val = $this->validate($val, $filters, $assertions);
    }
}
