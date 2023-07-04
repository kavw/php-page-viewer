<?php

declare(strict_types=1);

namespace PV\Infra\Tags;

readonly class Attribute implements \Stringable
{
    public function __construct(
        /**
         * @var string
         */
        public string $name,
        /**
         * @var bool|string
         */
        public bool|string $val
    ) {
    }

    public function __toString(): string
    {
        if (is_bool($this->val)) {
            return $this->val ? $this->name : '';
        }

        ob_start();
        echo encode($this->name), '="', encode($this->val), '"';

        return (string) ob_get_clean();
    }
}
