<?php

declare(strict_types=1);

namespace PV\App\Container;

use Psr\Log\LoggerInterface;
use PV\App\Settings;
use PV\Infra\Http\Server\Middleware\HttpMiddlewareChainFactory;
use PV\Infra\Http\Server\Middleware\HttpMiddlewareChainFactoryInterface;
use PV\Infra\Http\Server\Request\RequestFactory;
use PV\Infra\Http\Server\Request\RequestFactoryInterface;
use PV\Infra\Http\Server\Response\ResponseFactoryInterface;
use PV\Infra\Http\Server\Response\SimpleResponseFactory;
use PV\Infra\Profiling\ProfilerInterface;
use PV\Infra\Profiling\SimpleProfiler;

// phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps
abstract readonly class A00_Basic
// phpcs:enable
{
    /**
     * @param Settings $settings
     * @param resource|null $logStream
     * @param ProfilerInterface $globalProfiler
     */
    final public function __construct(
        public Settings $settings,
        protected mixed $logStream = null,
        protected ProfilerInterface $globalProfiler = new SimpleProfiler(),
    ) {
    }

    final public function getProjectRootDir(): string
    {
        static $path;
        return $path ?? $path = realpath(__DIR__ . '/../..');
    }

    final public function getRequestFactory(): RequestFactoryInterface
    {
        static $obj;
        return $obj ?? $obj = new RequestFactory();
    }

    final public function getResponseFactory(): ResponseFactoryInterface
    {
        static $obj;
        return $obj ?? $obj = new SimpleResponseFactory();
    }

    abstract public function getLogger(): LoggerInterface;

    final public function getHttpMiddlewareChainFactory(): HttpMiddlewareChainFactoryInterface
    {
        static $obj;
        return $obj ?? $obj = new HttpMiddlewareChainFactory(
            $this->getLogger()
        );
    }
}
