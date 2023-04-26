<?php

declare(strict_types=1);

namespace PV\App\Middleware;

use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use PV\App\Settings\FrontCache;
use PV\Infra\Http\Server\Middleware\HttpMainMiddlewareInterface;
use PV\Infra\Http\Server\Middleware\HttpMiddlewareInterface;
use PV\Infra\Http\Server\Request\SimpleRequestInterface;
use PV\Infra\Http\Server\Response\SimpleResponseInterface;

final readonly class FrontCacheMiddleware implements HttpMiddlewareInterface
{
    public function __construct(
        private CacheInterface $cache,
        private FrontCache $settings,
        private ?LoggerInterface $logger = null,
    ) {
    }

    public function __invoke(
        SimpleRequestInterface $request,
        HttpMainMiddlewareInterface|HttpMiddlewareInterface $next
    ): SimpleResponseInterface {
        if (!$this->settings->enabled->val) {
            $this->logger?->debug("Front cache. Disabled");
            return $next($request);
        }

        $this->logger?->debug("Front cache. Enabled");

        $key = $this->makeKey($request);
        $response = $this->cache->get($key);
        if ($response instanceof SimpleResponseInterface) {
            $this->logger?->debug("Front cache. Found response", ['key' => $key]);
            return $response;
        }

        $response = $next($request);
        $this->cache->set($key, $response, $this->settings->ttl->val);
        return $response;
    }

    private function makeKey(SimpleRequestInterface $request): string
    {
        return $request->getPath() . json_encode($request->getQueryParams());
    }
}
