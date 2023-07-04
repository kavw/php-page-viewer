<?php

declare(strict_types=1);

namespace PV\Infra\Secret;

interface SecretProviderInterface
{
    /**
     * @throws \RuntimeException
     */
    public function get(string $name): string;
}
