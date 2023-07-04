<?php

declare(strict_types=1);

namespace PV\App\Document;

use PV\App\Document\Raw\Factory\DbHtmlFactory;
use PV\App\Document\Raw\Factory\DbTextFactory;
use PV\App\Document\Raw\Factory\FactoryInterface;
use PV\App\Document\Raw\Factory\FsHtmlFactory;
use PV\App\Document\Raw\Factory\FsTextFactory;
use PV\App\Document\Raw\RawDocument;
use PV\App\Document\Raw\RawDocumentRepoInterface;
use PV\App\Document\Raw\RawDocumentSrcType;
use PV\App\Document\Raw\RawDocumentType;
use PV\App\Document\SimplifiedDummyMarkdown\Block\PrimaryHeader;
use PV\App\Document\SimplifiedDummyMarkdown\Parser;
use PV\Infra\FileSystem\FileLinesReader;

final readonly class DocumentRepo implements DocumentRepoInterface
{
    public function __construct(
        /**
         * @var RawDocumentRepoInterface[]
         */
        private iterable $concreteRepos,
        private LinkManager $linkManager = new LinkManager(),
        /**
         * @var iterable<FactoryInterface>
         */
        private iterable $factories = [
            new FsHtmlFactory(),
            new FsTextFactory(),
            new DbHtmlFactory(),
            new DbTextFactory(),
        ]
    ) {
    }

    public function findByLink(string $link): ?DocumentInterface
    {
        $res = $this->linkManager->fetchSrcTypeByLink($link);
        if (!$res) {
            return null;
        }

        foreach ($this->concreteRepos as $repo) {
            if (!$repo->supports($res['type'])) {
                continue;
            }

            $raw = $repo->findByLink($res['link']);
            if (!$raw) {
                continue;
            }

            return $this->createDocument($raw);
        }

        return null;
    }

    public function findAll(): iterable
    {
        foreach ($this->concreteRepos as $repo) {
            foreach ($repo->findAll() as $raw) {
                $document = $this->createDocument($raw);
                if ($document) {
                    yield $document;
                }
            }
        }
    }

    private function createDocument(RawDocument $raw): ?DocumentInterface
    {
        foreach ($this->factories as $factory) {
            $document = $factory->create($raw);
            if ($document) {
                return $document;
            }
        }

        return null;
    }
}
