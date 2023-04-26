<?php

declare(strict_types=1);

namespace PV\App\Document\SimplifiedDummyMarkdown\Block;

final class PrimaryHeaderFactory implements ConcreteFactoryInterface
{
    public function test(array $lines): ?PrimaryHeader
    {
        if (str_starts_with($lines[count($lines) - 1], '---')) {
            array_pop($lines);
            return new PrimaryHeader($lines);
        }

        if (str_starts_with($lines[count($lines) - 1], '===')) {
            array_pop($lines);
            return new PrimaryHeader($lines);
        }

        return null;
    }
}
