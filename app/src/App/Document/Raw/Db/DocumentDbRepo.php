<?php

declare(strict_types=1);

namespace PV\App\Document\Raw\Db;

use PV\App\Document\Raw\RawDocument;
use PV\App\Document\Raw\RawDocumentRepoInterface;
use PV\App\Document\Raw\RawDocumentSrcType;
use PV\Infra\DBAL\ConnectionManagerInterface;
use PV\Infra\DBAL\ContextInterface;

final readonly class DocumentDbRepo implements RawDocumentRepoInterface
{
    public function __construct(
        private ConnectionManagerInterface $connectionManager
    ) {
    }

    public function supports(RawDocumentSrcType $type): bool
    {
        return $type === RawDocumentSrcType::DB;
    }

    public function findByLink(string $link): ?RawDocument
    {
        if (\str_starts_with($link, '/')) {
            $link = substr($link, 1);
        }

        $conn = $this->connectionManager->getReadableConnection();
        return $conn->query(
            fn (ContextInterface $ctx) => yield <<<SQL
                SELECT link.link, page.title, page.mime, page.text 
                  FROM link 
            INNER JOIN page ON link.page_id = page.id 
                 WHERE link = {$ctx($link)}
            SQL
        )
            ->hydrate(DbDocument::class)
            ?->createRawDocument();
    }

    public function findAll(): iterable
    {
        $conn = $this->connectionManager->getReadableConnection();
        $entities = $conn->query(
            fn (ContextInterface $ctx) => yield <<<SQL
                SELECT link.link, page.title, page.mime, page.text 
                  FROM link 
            INNER JOIN page ON link.page_id = page.id
            SQL
        )
            ->hydrateAll(DbDocument::class);

        foreach ($entities as $item) {
            yield $item->createRawDocument();
        }
    }
}
