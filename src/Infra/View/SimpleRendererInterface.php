<?php

declare(strict_types=1);

namespace PV\Infra\View;

interface SimpleRendererInterface
{
    public function layout(ViewInterface $view): void;

    /**
     * @param non-empty-string $slotName
     * @return void
     */
    public function begin(string $slotName): void;

    public function end(): void;

    public function content(): string;

    public function slot(string $name, string $default = ''): string;

    public function render(): string;

    /**
     * @param ViewInterface $view
     * @return string
     * @throws \Throwable
     */
    public function include(ViewInterface $view): string;

    /**
     * @param string $name
     * @param array<string, string> $params
     * @return string
     */
    public function link(string $name, array $params = []): string;

    public function media(string $path): string;
}
