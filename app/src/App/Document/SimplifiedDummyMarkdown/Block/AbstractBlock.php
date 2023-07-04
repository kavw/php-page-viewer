<?php

declare(strict_types=1);

namespace PV\App\Document\SimplifiedDummyMarkdown\Block;

abstract class AbstractBlock implements BlockInterface
{
    public function __construct(
        /**
         * @var string[]
         */
        readonly protected array $lines = []
    ) {
    }

    public function getLines(): array
    {
        return $this->lines;
    }

    public function getContent(): string
    {
        return implode("\n", $this->lines);
    }

    abstract public function toHtml(): string;
}
