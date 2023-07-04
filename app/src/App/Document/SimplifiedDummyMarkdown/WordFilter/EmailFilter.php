<?php

declare(strict_types=1);

namespace PV\App\Document\SimplifiedDummyMarkdown\WordFilter;

final class EmailFilter implements WordFilterInterface
{
    public function __invoke(string $word): ?string
    {
        if (filter_var($word, FILTER_VALIDATE_EMAIL)) {
            return "<a href=\"mailto:{$word}\">{$word}</a>";
        }
        return null;
    }
}
