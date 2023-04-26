<?php

declare(strict_types=1);

namespace PV\App\Document\SimplifiedDummyMarkdown\Block;

final class ParagraphFactory implements ConcreteFactoryInterface
{
    /**
     * @param  string[] $lines
     * @return Paragraph|null
     */
    public function test(array $lines): ?Paragraph
    {
        return new Paragraph($lines);
    }
}
