<?php

declare(strict_types=1);

namespace PV\App\Document\SimplifiedDummyMarkdown\WordFilter;

final class LinkFilter implements WordFilterInterface
{
    public function __invoke(string $word): ?string
    {
        if (filter_var($word, FILTER_VALIDATE_URL)) {
            return "<a href=\"{$word}\">{$word}</a>";
        }
        return null;
    }
}
