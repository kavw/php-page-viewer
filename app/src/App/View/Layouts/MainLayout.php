<?php

declare(strict_types=1);

namespace PV\App\View\Layouts;

use PV\Infra\View\AbstractView;

final class MainLayout extends AbstractView
{
    public function __construct(
        readonly public string $searchTerm = ''
    ) {
    }
}
