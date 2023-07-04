<?php

declare(strict_types=1);

namespace PV\App\Document\SimplifiedDummyMarkdown\Block;

interface ConcreteFactoryInterface
{
    /**
     * @param  string[] $lines
     * @return BlockInterface|null
     */
    public function test(array $lines): ?BlockInterface;
}
