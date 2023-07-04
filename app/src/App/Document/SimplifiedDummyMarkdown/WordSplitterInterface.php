<?php

declare(strict_types=1);

namespace PV\App\Document\SimplifiedDummyMarkdown;

interface WordSplitterInterface
{
    /**
     * @param  string $line
     * @return iterable<string>
     */
    public function split(string $line): iterable;
}
