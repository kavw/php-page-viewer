<?php

declare(strict_types=1);

namespace PV\Infra\Http\Server\Response;

final class SimpleResponseFactory implements ResponseFactoryInterface
{
    public function create(
        string $content,
        Code $code = Code::OK,
        array $headers = ['Content-Type' => 'text/html'],
    ): SimpleResponseInterface {
        return new SimpleResponse($content, $code, $headers);
    }
}
