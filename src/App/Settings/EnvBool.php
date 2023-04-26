<?php

declare(strict_types=1);

namespace PV\App\Settings;

final readonly class EnvBool
{
    public bool $val;

    public function __construct(string $name, bool $default)
    {
        $this->val = !isset($_ENV[$name])
            ? $default
            : match (strtolower(trim($_ENV[$name]))) {
                '1', 'y', 'yes', 't', 'true', 'on', 'enabled' => true,
                '0', 'n', 'no', 'f', 'false', 'off', 'disabled' => false,
                default => throw new \InvalidArgumentException(
                    "Can't convert string '{$_ENV[$name]}' to boolean value"
                )
            };
    }
}
