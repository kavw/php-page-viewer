<?php

declare(strict_types=1);

namespace PV\Infra\Tags;

final class HtmlTag extends Tag
{
    public function __toString(): string
    {
        return '<!doctype html>' . parent::__toString();
    }
}
