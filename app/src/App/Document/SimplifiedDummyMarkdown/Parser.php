<?php

declare(strict_types=1);

namespace PV\App\Document\SimplifiedDummyMarkdown;

use PV\App\Document\SimplifiedDummyMarkdown\Block\BlockFactory;
use PV\App\Document\SimplifiedDummyMarkdown\Block\BlockFactoryInterface;
use PV\App\Document\SimplifiedDummyMarkdown\Block\BlockInterface;
use PV\App\Document\SimplifiedDummyMarkdown\WordFilter\EmailFilter;
use PV\App\Document\SimplifiedDummyMarkdown\WordFilter\LinkFilter;
use PV\App\Document\SimplifiedDummyMarkdown\WordFilter\WordFilterInterface;

final readonly class Parser
{
    /**
     * @param BlockFactoryInterface $blockFactory
     * @param WordSplitterInterface $wordSplitter
     * @param WordFilterInterface[] $wordFilters
     */
    public function __construct(
        private BlockFactoryInterface $blockFactory = new BlockFactory(),
        private WordSplitterInterface $wordSplitter = new WordSplitter(),
        private array $wordFilters = [new LinkFilter(), new EmailFilter()],
    ) {
    }

    /**
     * @param  iterable<string> $lines
     * @return BlockInterface[]
     */
    public function parse(iterable $lines): array
    {
        $blocks = [];
        $blockLines = [];
        foreach ($lines as $line) {
            $line = $this->processLine($line);
            if ($line) {
                $blockLines[] = $line;
                continue;
            }

            if ($blockLines) {
                $blocks[] = $this->blockFactory->create($blockLines);
                $blockLines = [];
            }
        }

        if ($blockLines) {
            $blocks[] = $this->blockFactory->create($blockLines);
        }

        return $blocks;
    }

    private function processLine(string $line): string
    {
        $newLine = [];
        foreach ($this->wordSplitter->split($line) as $word) {
            if ($this->isSyntaxMark($word)) {
                if ($newLine) {
                    $newLine[count($newLine) - 1] .= $word;
                    continue;
                }

                $newLine[] = $word;
                continue;
            }

            foreach ($this->wordFilters as $filter) {
                $filtered = $filter($word);
                if ($filtered) {
                    $newLine[] = $filtered;
                    continue(2);
                }
            }

            $newLine[] = $word;
        }

        return implode(' ', $newLine);
    }

    private function isSyntaxMark(string $word): bool
    {
        return match ($word) {
            ",", ".", ":", "!", "?" => true,
            default => false
        };
    }
}
