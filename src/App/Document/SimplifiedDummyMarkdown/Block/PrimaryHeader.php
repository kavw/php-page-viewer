<?php

declare(strict_types=1);

namespace PV\App\Document\SimplifiedDummyMarkdown\Block;

final class PrimaryHeader extends AbstractBlock
{
    public function toHtml(): string
    {
        return $this->lines
            ? '<h1>' . implode("\n", $this->getLines()) . '</h1>'
            : '';
    }
}
