<?php

declare(strict_types=1);

namespace PV\Infra\Test;

use PHPUnit\Framework\TestCase;
use PV\App\HttpApp;

abstract class AbstractPageTestCase extends TestCase
{
    /**
     * @var array<string, string>|null
     */
    private ?array $env = null;

    protected function setUp(): void
    {
        $this->env = $_ENV;
        $_ENV['PV_ROUTE_PREFIX'] = '';
    }

    protected function tearDown(): void
    {
        if (!$this->env) {
            throw new \LogicException(
                "Something goes wrong"
            );
        }
        $_ENV = $this->env;
    }

    /**
     * @param  string                $path
     * @param  array<string, string> $queryParams
     * @return Response
     */
    protected function sendRequest(
        string $path,
        array $queryParams = []
    ): Response {
        $app = HttpApp::create();
        $chain = $app->boot();
        $req = $app->getContainer()
            ->getRequestFactory()
            ->create($path, $queryParams);

        return new Response($this, $chain->run($req));
    }
}
