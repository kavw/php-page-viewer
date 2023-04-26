<?php

declare(strict_types=1);

namespace PV\App\Document\Raw\Factory;

use PV\App\Document\DocumentInterface;
use PV\App\Document\Raw\RawDocument;

interface FactoryInterface
{
    public function create(RawDocument $raw): ?DocumentInterface;
}
