<?php

declare(strict_types=1);

namespace PV\Infra\Tags;

final class SingleTag extends Tag
{
    public function __toString(): string
    {
        if (!$this->attr) {
            return "<$this->name />";
        }

        return implode(
            '',
            [
            "<$this->name ",
            implode(' ', array_map(fn ($a) => (string)$a, $this->attr)),
            " />"
            ]
        );
    }
}
