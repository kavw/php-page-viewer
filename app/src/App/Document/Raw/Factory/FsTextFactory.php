<?php

declare(strict_types=1);

namespace PV\App\Document\Raw\Factory;

use PV\App\Document\Document;
use PV\App\Document\DocumentInterface;
use PV\App\Document\LinkManager;
use PV\App\Document\Raw\RawDocument;
use PV\App\Document\Raw\RawDocumentSrcType;
use PV\App\Document\Raw\RawDocumentType;
use PV\App\Document\SimplifiedDummyMarkdown\Parser;
use PV\Infra\FileSystem\FileLinesReader;

final class FsTextFactory extends AbstractTextFactory implements FactoryInterface
{
    public function __construct(
        readonly private LinkManager $linkManager = new LinkManager(),
        readonly private FileLinesReader $linesReader = new FileLinesReader(),
        Parser $parser = new Parser(),
    ) {
        parent::__construct($parser);
    }

    public function create(RawDocument $raw): ?DocumentInterface
    {
        if ($raw->srcType !== RawDocumentSrcType::FS) {
            return null;
        }

        if ($raw->type !== RawDocumentType::TEXT) {
            return  null;
        }

        $res = $this->parseText(
            $this->linesReader->read($raw->content)
        );
        $link = $this->linkManager->makeLink($raw);
        return $link ? new Document($res['title'], $link, $res['content']) : null;
    }
}
