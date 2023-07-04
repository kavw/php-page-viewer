<?php

declare(strict_types=1);

namespace PV\App\Document;

interface DocumentInterface
{
    public function getTitle(): string;

    public function getContent(): string;

    public function getLink(): string;
}
