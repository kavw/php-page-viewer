<?php

declare(strict_types=1);

namespace PV\App\Document\Raw\Factory;

use PV\App\Document\Document;
use PV\App\Document\DocumentInterface;
use PV\App\Document\HtmlHeadlineExtractor;
use PV\App\Document\LinkManager;
use PV\App\Document\Raw\RawDocument;
use PV\App\Document\Raw\RawDocumentSrcType;
use PV\App\Document\Raw\RawDocumentType;

final readonly class FsHtmlFactory implements FactoryInterface
{
    public function __construct(
        private LinkManager $linkManager = new LinkManager(),
        private HtmlHeadlineExtractor $headlineExtractor = new HtmlHeadlineExtractor(),
    ) {
    }

    public function create(RawDocument $raw): ?DocumentInterface
    {
        if ($raw->srcType !== RawDocumentSrcType::FS) {
            return null;
        }

        if ($raw->type !== RawDocumentType::HTML) {
            return  null;
        }

        $content = (string) file_get_contents($raw->content);
        $title = $this->headlineExtractor->extract($content) ?? '';
        $link = $this->linkManager->makeLink($raw);
        return $link ? new Document($title, $link, $content) : null;
    }
}
