<?php

declare(strict_types=1);

namespace PV\App\Document\Search;

use PV\App\Document\DocumentInterface;
use PV\App\Document\DocumentRepoInterface;

final readonly class DummySearchRepo implements SearchRepoInterface
{
    public function __construct(
        private DocumentRepoInterface $documentRepo
    ) {
    }

    /**
     * @inheritdoc
     */
    public function find(string $text): SearchResultInterface
    {
        $text = mb_strtolower($text);
        return new SearchResult($this->doSearch($text));
    }

    /**
     * @param string $text
     * @return iterable<DocumentInterface>
     */
    private function doSearch(string $text): iterable
    {
        foreach ($this->documentRepo->findAll() as $item) {
            if (mb_strpos(mb_strtolower($item->getContent()), $text) !== false) {
                yield $item;
            }
        }
    }
}
