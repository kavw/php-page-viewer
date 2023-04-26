<?php

declare(strict_types=1);

namespace PV\App\Document\Search;

use PV\App\Document\DocumentInterface;

interface SearchRepoInterface
{
    /**
     * @param  string $text
     * @return SearchResultInterface
     */
    public function find(string $text): SearchResultInterface;
}
