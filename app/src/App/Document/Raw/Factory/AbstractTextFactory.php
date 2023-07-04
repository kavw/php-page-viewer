<?php

declare(strict_types=1);

namespace PV\App\Document\Raw\Factory;

use PV\App\Document\SimplifiedDummyMarkdown\Block\PrimaryHeader;
use PV\App\Document\SimplifiedDummyMarkdown\Parser;

abstract class AbstractTextFactory
{
    public function __construct(
        readonly private Parser $parser = new Parser(),
    ) {
    }

    /**
     * @param  iterable<string> $lines
     * @return array{title: string, content: string}
     */
    protected function parseText(iterable $lines): array
    {
        $title = '';
        $content = [];
        $blocks = $this->parser->parse($lines);

        foreach ($blocks as $block) {
            if ($block instanceof PrimaryHeader && !$title) {
                $title = $block->getContent();
            }
            $content[] = $block->toHtml();
        }

        return ['title' => $title, 'content' => implode("\n", $content)];
    }
}
