<?php

declare(strict_types=1);

namespace PV\App\Container;

use PV\App\Middleware\FrontCacheMiddleware;
use PV\App\Middleware\ProfilingMiddleware;
use PV\App\Middleware\RequestHandlerMiddleware;
use PV\App\Middleware\UserAwareExceptionsHandlerMiddleware;

// phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps
abstract readonly class A04_Middleware extends A03_Routes
// phpcs:enable
{
    final public function getProfilingMiddleware(): ProfilingMiddleware
    {
        static $obj;
        return $obj ?? $obj = new ProfilingMiddleware(
            $this->globalProfiler,
            $this->getResponseFactory(),
        );
    }

    final public function getRequestHandlerMiddleware(): RequestHandlerMiddleware
    {
        static $obj;
        return $obj ?? $obj = new RequestHandlerMiddleware(
            $this->getRouter(),
            $this->getResponseFactory(),
        );
    }

    final public function getUserAwareExceptionHandlerMiddleware(): UserAwareExceptionsHandlerMiddleware
    {
        return new UserAwareExceptionsHandlerMiddleware(
            $this->getRender(),
            $this->getResponseFactory()
        );
    }


    public function getFrontCacheMiddleware(): FrontCacheMiddleware
    {
        return new FrontCacheMiddleware(
            $this->getCache('front-cache'),
            $this->settings->frontCache,
            $this->getLogger()
        );
    }
}
