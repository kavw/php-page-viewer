<?php

declare(strict_types=1);

namespace PV\App\Document\SimplifiedDummyMarkdown\Block;

final class UnorderedList extends AbstractBlock
{
    public function toHtml(): string
    {
        if (!$this->lines) {
            return '';
        }

        $lines = [];
        foreach ($this->lines as $item) {
            $lines[] = "<li>{$item}</li>";
        }

        return '<ul>' . implode('', $lines) . '</ul>';
    }
}
