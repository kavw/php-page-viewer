<?php

declare(strict_types=1);

namespace PV\App\Document\SimplifiedDummyMarkdown;

final class WordSplitter implements WordSplitterInterface
{
    public function split(string $line): \Generator
    {
        $word  = [];
        for ($i = 0; $i < strlen($line); $i++) {
            $ch = $line[$i];
            if (!$this->isBlank($ch)) {
                $word[] = $ch;
                continue;
            }

            if (!$word) {
                continue;
            }

            if ($this->isSyntaxMark($word[count($word) - 1])) {
                $mark = array_pop($word);
                yield implode('', $word);
                yield $mark;
                $word = [];
                continue;
            }

            yield implode('', $word);
            $word = [];
        }
    }

    private function isBlank(string $ch): bool
    {
        return match ($ch) {
            " ", "\n", "\r", "\t", "\f" => true,
            default => false
        };
    }

    private function isSyntaxMark(string $ch): bool
    {
        return match ($ch) {
            ",", ".", ":", "!", "?" => true,
            default => false
        };
    }
}
