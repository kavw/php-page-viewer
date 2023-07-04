<?php

declare(strict_types=1);

namespace PV\Infra\Http\Server\Response;

interface SimpleResponseInterface
{
    public function getContent(): string;

    public function getCode(): Code;

    /**
     * @return array<string, string>
     */
    public function getHeaders(): array;

    public function send(): void;
}
