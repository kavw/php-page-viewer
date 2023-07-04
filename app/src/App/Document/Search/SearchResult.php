<?php

declare(strict_types=1);

namespace PV\App\Document\Search;

use PV\App\Document\DocumentInterface;

final class SearchResult implements SearchResultInterface
{
    private ?DocumentInterface $prev = null;
    private ?bool $empty = null;

    public function __construct(
        /**
         * @var iterable<DocumentInterface>
         */
        readonly private iterable $items
    ) {
    }

    public function empty(): bool
    {
        if ($this->empty !== null) {
            return $this->empty;
        }

        foreach ($this->items as $item) {
            $this->prev = $item;
            break;
        }
        return $this->empty = $this->prev === null;
    }

    /**
     * @return iterable<DocumentInterface>
     */
    public function items(): iterable
    {
        $this->empty();
        if ($this->prev === null) {
            return [];
        }

        foreach ($this->items as $item) {
            yield $item;
        }
    }
}
