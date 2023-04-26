<?php

declare(strict_types=1);

namespace PV\Infra\View;

use PV\App\Container;
use PV\Infra\Http\Server\Router\RouterInterface;
use PV\Infra\WebResource\WebResourceManagerInterface;

final readonly class RendererFactory implements RendererFactoryInterface
{
    public function __construct(
        private RouterInterface $router,
        private WebResourceManagerInterface $resourceManager,
        private string $projRootDir,
    ) {
    }

    public function create(ViewInterface $view): SimpleRendererInterface
    {
        return new SimpleRenderer(
            $view,
            $this->projRootDir,
            $this->router,
            $this->resourceManager,
        );
    }
}
