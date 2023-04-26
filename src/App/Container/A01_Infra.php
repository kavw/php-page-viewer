<?php

declare(strict_types=1);

namespace PV\App\Container;

use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use PV\Infra\Cache\SimpleAPCuCache;
use PV\Infra\DBAL\ConnectionManager;
use PV\Infra\DBAL\ConnectionManagerInterface;
use PV\Infra\Http\Server\Router\RouterInterface;
use PV\Infra\Hydrator\HydratorInterface;
use PV\Infra\Hydrator\SimpleHydrator;
use PV\Infra\Logger\SimpleStreamLogger;
use PV\Infra\Secret\EnvSecretProvider;
use PV\Infra\Secret\SecretProviderInterface;
use PV\Infra\View\Render;
use PV\Infra\View\RendererFactory;
use PV\Infra\View\RendererFactoryInterface;
use PV\Infra\View\RenderInterface;
use PV\Infra\WebResource\WebResourceManager;
use PV\Infra\WebResource\WebResourceManagerInterface;

// phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps
abstract readonly class A01_Infra extends A00_Basic
// phpcs:enable
{
    final public function getLogger(): LoggerInterface
    {
        return new SimpleStreamLogger(
            $this->logStream,
            $this->settings->logger->logLevel,
        );
    }

    final public function getCache(string $namespace): CacheInterface
    {
        static $instances = [];
        if (!isset($instances[$namespace])) {
            $instances[$namespace] = new SimpleAPCuCache($namespace);
        }
        return $instances[$namespace];
    }

    final public function getSecretProvider(): SecretProviderInterface
    {
        static $obj;
        return $obj ?? $obj = new EnvSecretProvider();
    }

    final public function getWebResourceManager(): WebResourceManagerInterface
    {
        static $obj;
        return $obj ?? $obj = new WebResourceManager(
            (string)realpath(__DIR__ . '/../../../public/rev-manifest.json'),
            uriPrefix: $this->settings->mediaPrefix->val
        );
    }

    abstract public function getRouter(): RouterInterface;

    final public function getRendererFactory(): RendererFactoryInterface
    {
        static $obj;
        return $obj ?? $obj = new RendererFactory(
            $this->getRouter(),
            $this->getWebResourceManager(),
            $this->getProjectRootDir(),
        );
    }

    final public function getRender(): RenderInterface
    {
        static $obj;
        return $obj ?? $obj = new Render(
            $this->getRendererFactory()
        );
    }

    final public function getHydrator(): HydratorInterface
    {
        return new SimpleHydrator();
    }

    final public function getConnectionManager(): ConnectionManagerInterface
    {
        static $obj;
        return $obj ?? $obj = new ConnectionManager(
            $this->getSecretProvider(),
            $this->getHydrator(),
            $this->getLogger(),
        );
    }
}
