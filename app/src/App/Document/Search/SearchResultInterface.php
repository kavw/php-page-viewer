<?php

declare(strict_types=1);

namespace PV\App\Document\Search;

use PV\App\Document\DocumentInterface;

interface SearchResultInterface
{
    public function empty(): bool;

    /**
     * @return iterable<DocumentInterface>
     */
    public function items(): iterable;
}
