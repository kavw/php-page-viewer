<?php

declare(strict_types=1);

namespace PV\App\Document\SimplifiedDummyMarkdown\Block;

interface BlockInterface
{
    /**
     * @return string[]
     */
    public function getLines(): array;

    public function getContent(): string;

    public function toHtml(): string;
}
