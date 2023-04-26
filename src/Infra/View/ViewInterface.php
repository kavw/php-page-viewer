<?php

declare(strict_types=1);

namespace PV\Infra\View;

interface ViewInterface
{
    public function getTemplatePath(): string;
}
