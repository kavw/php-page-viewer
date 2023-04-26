<?php

declare(strict_types=1);

namespace PV\Infra\Http\Server\Middleware;

use Psr\Log\LoggerInterface;
use PV\Infra\Http\Server\Request\SimpleRequestInterface;
use PV\Infra\Http\Server\Response\SimpleResponseInterface;

final class HttpMiddlewareChain implements HttpMiddlewareChainInterface
{
    /**
     * @var array<HttpMainMiddlewareInterface|HttpMiddlewareInterface>
     */
    private array $middleware = [];

    public function __construct(
        HttpMainMiddlewareInterface $middleware,
        readonly private ?LoggerInterface $logger = null,
    ) {
        $this->middleware[] = $middleware;
    }

    public function push(HttpMiddlewareInterface $middleware): void
    {
        $this->middleware[] = $middleware;
    }

    public function run(SimpleRequestInterface $req): SimpleResponseInterface
    {
        $next  = null;
        for ($i = 0; $i < \count($this->middleware); $i++) {
            $curr = $this->middleware[$i];

            $wrap = new class ($curr, $next, $this->logger) implements
                HttpMainMiddlewareInterface,
                HttpMiddlewareInterface
            {
                public function __construct(
                    readonly private HttpMiddlewareInterface|HttpMainMiddlewareInterface $curr,
                    readonly private HttpMiddlewareInterface|HttpMainMiddlewareInterface|null $next,
                    readonly private ?LoggerInterface $logger = null
                ) {
                }

                public function __invoke(
                    SimpleRequestInterface $request,
                    HttpMiddlewareInterface|HttpMainMiddlewareInterface|null $next = null
                ): SimpleResponseInterface {
                    $class = get_class($this->curr);
                    $this->logger?->debug("Middleware {$class} is starting");

                    $result = $this->next instanceof HttpMiddlewareInterface
                        ? $this->curr->__invoke($request, $this->next)
                        : $this->curr->__invoke($request);

                    $this->logger?->debug("Middleware {$class} has been completed");
                    return $result;
                }
            };

            $next = $wrap;
        }

        return is_callable($next)
            ? $next($req)
            : throw new \LogicException("The \$next must be callable");
    }
}
