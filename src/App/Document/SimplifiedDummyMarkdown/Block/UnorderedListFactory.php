<?php

declare(strict_types=1);

namespace PV\App\Document\SimplifiedDummyMarkdown\Block;

final class UnorderedListFactory implements ConcreteFactoryInterface
{
    /**
     * @param  string[] $lines
     * @return BlockInterface|null
     */
    public function test(array $lines): ?BlockInterface
    {
        $newLines = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if (!str_starts_with($line, '*')) {
                return null;
            }
            $newLines[] = substr($line, 1);
        }

        return new UnorderedList($newLines);
    }
}
