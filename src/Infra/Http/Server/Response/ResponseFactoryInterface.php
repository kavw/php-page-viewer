<?php

declare(strict_types=1);

namespace PV\Infra\Http\Server\Response;

interface ResponseFactoryInterface
{
    /**
     * @param  string                $content
     * @param  Code                  $code
     * @param  array<string, string> $headers
     * @return SimpleResponseInterface
     */
    public function create(
        string $content,
        Code $code = Code::OK,
        array $headers = ['Content-Type' => 'text/html'],
    ): SimpleResponseInterface;
}
