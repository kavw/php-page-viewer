<?php

declare(strict_types=1);

namespace PV\App\Document\View;

use PV\App\Document\Document;
use PV\App\Document\Routes\Item\ItemController;
use PV\Infra\View\AbstractView;

final class ListItemView extends AbstractView
{
    public function __construct(
        readonly public Document $document,
        readonly public int $tabIdxBase,
        readonly public int $idx,
        readonly public bool $last,
    ) {
    }
}
