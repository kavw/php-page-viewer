<?php

declare(strict_types=1);

namespace PV\App\Document\SimplifiedDummyMarkdown\Block;

final class Paragraph extends AbstractBlock
{
    public function toHtml(): string
    {
        return $this->lines
            ? '<p>' . implode("\n", $this->getLines()) . '</p>'
            : '';
    }
}
