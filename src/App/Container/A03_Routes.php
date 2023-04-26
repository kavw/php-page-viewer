<?php

declare(strict_types=1);

namespace PV\App\Container;

use PV\App\Document\Routes\Home\HomeController;
use PV\App\Document\Routes\Item\ItemController;
use PV\App\Document\Routes\Search\SearchController;
use PV\Infra\Http\Server\Router\Router;
use PV\Infra\Http\Server\Router\RouterInterface;

// phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps
abstract readonly class A03_Routes extends A02_Documents
// phpcs:enable
{
    final public function getRouter(): RouterInterface
    {
        static $router;
        if ($router !== null) {
            return $router;
        }

        $router = new Router(
            $this->getLogger(),
            uriPrefix: $this->settings->routePrefix->val
        );

        $router->addRouteHandler($this->getItemController());
        $router->addRouteHandler($this->getSearchController());
        $router->addRouteHandler($this->getHomeController());

        return $router;
    }

    final public function getHomeController(): HomeController
    {
        static $obj;
        return $obj ?? $obj = new HomeController(
            $this->getDocumentRepo(),
            $this->getRender(),
        );
    }

    final public function getItemController(): ItemController
    {
        static $obj;
        return $obj ?? $obj = new ItemController(
            $this->getDocumentRepo(),
            $this->getRender(),
        );
    }

    final public function getSearchController(): SearchController
    {
        static $obj;
        return $obj ?? $obj = new SearchController(
            $this->getSearchRepo(),
            $this->getRender(),
        );
    }
}
