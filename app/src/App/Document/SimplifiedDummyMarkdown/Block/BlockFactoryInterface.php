<?php

declare(strict_types=1);

namespace PV\App\Document\SimplifiedDummyMarkdown\Block;

interface BlockFactoryInterface
{
    /**
     * @param  string[] $lines
     * @return BlockInterface
     */
    public function create(array $lines): BlockInterface;
}
