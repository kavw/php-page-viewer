<?php

declare(strict_types=1);

namespace PV\App\Document\SimplifiedDummyMarkdown\Block;

final class SecondaryHeaderFactory implements ConcreteFactoryInterface
{
    /**
     * @param  string[] $lines
     * @return SecondaryHeader|null
     */
    public function test(array $lines): ?SecondaryHeader
    {
        $i = 0;
        while ($i < strlen($lines[0]) - 1 || $i < 5) {
            if ($lines[0][$i] != '#') {
                break;
            }
            $i++;
        }

        if ($i < 2 || $i > 6) {
            return null;
        }

        $lines[0] = substr($lines[0], $i + 1);
        if (trim($lines[0])) {
            return new SecondaryHeader($i, $lines);
        }

        return null;
    }
}
