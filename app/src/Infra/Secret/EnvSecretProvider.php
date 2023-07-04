<?php

declare(strict_types=1);

namespace PV\Infra\Secret;

final class EnvSecretProvider implements SecretProviderInterface
{
    public function get(string $name): string
    {
        return $_ENV[$name]
            ?? throw new \InvalidArgumentException(
                "There is no environment variable '$name'"
            );
    }
}
