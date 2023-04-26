<?php

declare(strict_types=1);

namespace PV\Infra\View;

interface RendererFactoryInterface
{
    public function create(ViewInterface $view): SimpleRendererInterface;
}
