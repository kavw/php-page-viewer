<?php

namespace PV\App\Document;

final readonly class Document implements DocumentInterface
{
    public function __construct(
        public string $title,
        public string $link,
        public string $content
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
