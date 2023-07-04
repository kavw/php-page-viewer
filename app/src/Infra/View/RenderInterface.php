<?php

declare(strict_types=1);

namespace PV\Infra\View;

interface RenderInterface
{
    public function __invoke(AbstractView $view): string;
}
