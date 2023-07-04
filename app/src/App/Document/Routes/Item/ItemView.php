<?php

declare(strict_types=1);

namespace PV\App\Document\Routes\Item;

use PV\App\Document\DocumentInterface;
use PV\Infra\View\AbstractView;

final class ItemView extends AbstractView
{
    public function __construct(
        public readonly DocumentInterface $document
    ) {
    }
}
