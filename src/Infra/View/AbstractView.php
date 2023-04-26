<?php

declare(strict_types=1);

namespace PV\Infra\View;

abstract class AbstractView implements ViewInterface
{
    public function getTemplatePath(): string
    {
        $class = array_slice(explode('\\', get_class($this)), 1);
        return implode('/', $class) . '.phtml';
    }
}
