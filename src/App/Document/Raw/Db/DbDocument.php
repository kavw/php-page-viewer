<?php

declare(strict_types=1);

namespace PV\App\Document\Raw\Db;

use PV\App\Document\Raw\RawDocument;
use PV\App\Document\Raw\RawDocumentSrcType;
use PV\App\Document\Raw\RawDocumentType;

final readonly class DbDocument
{
    public function __construct(
        public string $link,
        public string $title,
        public string $mime,
        public string $text,
    ) {
    }

    public function createRawDocument(): RawDocument
    {
        return new RawDocument(
            RawDocumentSrcType::DB,
            match ($this->mime) {
                'text/html'  => RawDocumentType::HTML,
                'text/plain' => RawDocumentType::TEXT,
                default      => RawDocumentType::UNKNOWN,
            },
            $this->link,
            $this->text,
            $this->title,
        );
    }
}
