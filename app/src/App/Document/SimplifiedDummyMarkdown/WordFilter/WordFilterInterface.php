<?php

declare(strict_types=1);

namespace PV\App\Document\SimplifiedDummyMarkdown\WordFilter;

interface WordFilterInterface
{
    public function __invoke(string $word): ?string;
}
