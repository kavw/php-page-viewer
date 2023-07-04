<?php

declare(strict_types=1);

namespace PV\App\Document\View;

use PV\App\Document\DocumentInterface;
use PV\Infra\View\AbstractView;

final class ListView extends AbstractView
{
    public function __construct(
        /**
         * @var iterable<DocumentInterface>
         */
        readonly public iterable $documents = []
    ) {
    }
}
