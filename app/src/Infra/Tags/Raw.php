<?php

declare(strict_types=1);

namespace PV\Infra\Tags;

final readonly class Raw implements \Stringable
{
    public function __construct(
        public string $val
    ) {
    }

    public function __toString()
    {
        return $this->val;
    }
}
