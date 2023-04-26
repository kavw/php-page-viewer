<?php

namespace PV\App\Document;

interface DocumentRepoInterface
{
    public function findByLink(string $link): ?DocumentInterface;

    /**
     * @return DocumentInterface[]
     */
    public function findAll(): iterable;
}
