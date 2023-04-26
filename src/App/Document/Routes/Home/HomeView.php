<?php

declare(strict_types=1);

namespace PV\App\Document\Routes\Home;

use PV\App\Document\DocumentInterface;
use PV\Infra\View\AbstractView;

final class HomeView extends AbstractView
{
    public const PATH = 'home';
    public function __construct(
        readonly public string $title = 'Home',
        /**
         * @var iterable<DocumentInterface>
         */
        readonly public iterable $docs = [],
        readonly public string $message = '',
        readonly public string $searchTerm = '',
    ) {
    }
}
