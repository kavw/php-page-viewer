<?php

declare(strict_types=1);

namespace PV\Infra\Http\Server\Router;

use Psr\Log\LoggerInterface;
use PV\App\Exceptions\NotFoundException;
use PV\Infra\Http\Server\Request\SimpleRequestInterface;
use PV\Infra\Http\Server\Response\SimpleResponseInterface;

final class Router implements RouterInterface
{
    /**
     * @var RouteHandlerInterface[]
     */
    private array $handlers = [];

    public function __construct(
        readonly private ?LoggerInterface $logger = null,
        readonly private string $uriPrefix = ''
    ) {
    }


    public function addRouteHandler(RouteHandlerInterface $handler): void
    {
        $name = $handler->getName();
        if (isset($this->handlers[$name])) {
            throw new \LogicException("Handler '$name' has been added already");
        }

        $this->handlers[$name] = $handler;
    }

    public function dispatch(SimpleRequestInterface $req): string|SimpleResponseInterface
    {
        $this->logger?->debug("Starting request dispatch: '{$req->getPath()}'");

        $req = $this->testPrefix($req);

        foreach ($this->handlers as $handler) {
            $instance = $handler->match($req);
            if (!$instance) {
                continue;
            }

            $class = get_class($handler);
            $this->logger?->debug(
                "Request '{$req->getPath()}' has been matched by handler: {$class}"
            );

            $this->logger?->debug("Request handler {$class} is starting");
            $res =  $instance($req);
            $this->logger?->debug("Request handler {$class} has been completed");
            return $res;
        }

        throw new NotFoundException();
    }

    /**
     * @param  string                $name
     * @param  array<string, string> $params
     * @return string
     */
    public function link(string $name, array $params = []): string
    {
        if (!isset($this->handlers[$name])) {
            throw new \LogicException("There is no handler with name '$name'");
        }

        return $this->uriPrefix . $this->handlers[$name]->link($params);
    }

    private function testPrefix(SimpleRequestInterface $req): SimpleRequestInterface
    {
        if (!$this->uriPrefix) {
            return $req;
        }

        if (!\str_starts_with($req->getPath(), $this->uriPrefix)) {
            return $req;
        }

        $path = substr($req->getPath(), strlen($this->uriPrefix));
        if ($path === '') {
            $path = '/';
        }

        $req = $req->replacePath($path);

        $this->logger?->debug(
            "Cut uri prefix '{$this->uriPrefix}'. Updated request: '{$req->getPath()}'"
        );

        return $req;
    }
}
