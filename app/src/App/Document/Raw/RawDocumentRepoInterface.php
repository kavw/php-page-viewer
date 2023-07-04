<?php

declare(strict_types=1);

namespace PV\App\Document\Raw;

interface RawDocumentRepoInterface
{
    public function supports(RawDocumentSrcType $type): bool;

    public function findByLink(string $link): ?RawDocument;

    /**
     * @return RawDocument[]
     */
    public function findAll(): iterable;
}
