<?php

namespace PV\App\Document\Raw\Fs;

use PV\App\Document\Raw\RawDocument;
use PV\App\Document\Raw\RawDocumentRepoInterface;
use PV\App\Document\Raw\RawDocumentSrcType;
use PV\App\Document\Raw\RawDocumentType;
use SplFileInfo;

class DocumentFsRepo implements RawDocumentRepoInterface
{
    private RawDocumentSrcType $type = RawDocumentSrcType::FS;

    public function __construct(
        readonly private string $storageDir,
    ) {
    }

    public function supports(RawDocumentSrcType $type): bool
    {
        return $type === $this->type;
    }

    public function findByLink(string $link): ?RawDocument
    {
        $path = $this->storageDir . '/' . $link;
        if (!file_exists($path) || !is_readable($path)) {
            return null;
        }

        if (\str_ends_with($link, '.html')) {
            return new RawDocument($this->type, RawDocumentType::HTML, $link, $path);
        }

        if (\str_ends_with($link, '.txt')) {
            return new RawDocument($this->type, RawDocumentType::TEXT, $link, $path);
        }

        return null;
    }

    public function findAll(): iterable
    {
        $types = [
            'txt' => RawDocumentType::TEXT,
            'html' => RawDocumentType::HTML
        ];

        $it = new \DirectoryIterator($this->storageDir);
        foreach (new \RegexIterator($it, '/\.(txt|html)$/') as $file) {
            /**
             * @var SplFileInfo $file
             */
            $type = $types[$file->getExtension()] ?? null;
            if (!$type) {
                continue;
            }

            yield new RawDocument(
                $this->type,
                $type,
                $file->getBasename(),
                $file->getPath() . '/' . $file->getBasename()
            );
        }
    }
}
