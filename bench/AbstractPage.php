<?php

declare(strict_types=1);

namespace PV\Bench;

use PV\App\HttpApp;

abstract class AbstractPage
{
    protected function executeRequest(string $path, array $query = []): void
    {
        $app = HttpApp::create();
        $chain = $app->boot();

        $req = $app->getContainer()
            ->getRequestFactory()
            ->create($path, $query);

        $chain->run($req);
    }
}