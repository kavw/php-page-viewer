<?php

declare(strict_types=1);

namespace PV\Infra\Http\Server\Response;

final readonly class SimpleResponse implements SimpleResponseInterface
{
    /**
     * @param string $content
     * @param Code $code
     * @param array<string, string> $headers
     */
    public function __construct(
        private string $content,
        private Code $code = Code::OK,
        private array $headers = ['Content-Type' => 'text/html'],
    ) {
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCode(): Code
    {
        return $this->code;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function send(): void
    {
        http_response_code($this->code->value);
        foreach ($this->headers as $k => $v) {
            header("$k: $v", true);
        }

        echo $this->content;
    }
}
