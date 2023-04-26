<?php

declare(strict_types=1);

namespace PV\App\Document\SimplifiedDummyMarkdown\Block;

final class SecondaryHeader extends AbstractBlock
{
    /**
     * @param int      $level
     * @param string[] $lines
     */
    public function __construct(
        readonly private int $level,
        array $lines = []
    ) {
        parent::__construct($lines);
    }

    public function toHtml(): string
    {
        return $this->lines
            ? "<h{$this->level}>" .
                implode("\n", $this->getLines()) .
                "</h{$this->level}>"
            : '';
    }
}
