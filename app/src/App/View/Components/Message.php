<?php

declare(strict_types=1);

namespace PV\App\View\Components;

use PV\Infra\View\AbstractView;

final class Message extends AbstractView
{
    public function __construct(
        readonly public string $text,
        readonly public string $type = 'info'
    ) {
    }
}
