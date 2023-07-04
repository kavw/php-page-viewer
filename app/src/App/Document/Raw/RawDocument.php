<?php

declare(strict_types=1);

namespace PV\App\Document\Raw;

final readonly class RawDocument
{
    public function __construct(
        public RawDocumentSrcType $srcType,
        public RawDocumentType $type,
        public string $link,
        public string $content,
        public string $title = '',
    ) {
    }
}
