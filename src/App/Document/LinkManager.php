<?php

declare(strict_types=1);

namespace PV\App\Document;

use PV\App\Document\Raw\RawDocument;
use PV\App\Document\Raw\RawDocumentSrcType;

final class LinkManager
{
    private const PREFIXES = [
        '/fs' => RawDocumentSrcType::FS,
        '/db' => RawDocumentSrcType::DB,
    ];

    /**
     * @param  string $link
     * @return array{type: RawDocumentSrcType, link: string}|null
     */
    public function fetchSrcTypeByLink(string $link): ?array
    {
        foreach (self::PREFIXES as $k => $v) {
            if (str_starts_with($link, $k)) {
                return ['type' => $v, 'link' => substr($link, strlen($k))];
            }
        }
        return null;
    }

    public function makeLink(RawDocument $raw): ?string
    {
        foreach (self::PREFIXES as $k => $v) {
            if ($raw->srcType === $v) {
                return  $k . '/' . $raw->link;
            }
        }

        return null;
    }
}
