<?php

namespace PV\App\Document\Routes\Home;

use PV\App\Document\DocumentRepoInterface;
use PV\Infra\Http\Server\Request\SimpleRequestInterface;
use PV\Infra\Http\Server\Router\RouteHandlerInterface;
use PV\Infra\View\RendererFactoryInterface;
use PV\Infra\View\RenderInterface;

final class HomeController implements RouteHandlerInterface
{
    public const NAME = 'home';

    public function __construct(
        readonly private DocumentRepoInterface $documentRepo,
        readonly private RenderInterface $render,
    ) {
    }

    public function __invoke(SimpleRequestInterface $req): string
    {
        $docs = $this->documentRepo->findAll();

        return ($this->render)(new HomeView(
            docs: $docs,
        ));
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function link(array $params = []): string
    {
        return '/';
    }

    public function match(SimpleRequestInterface $req): ?RouteHandlerInterface
    {
        if ($req->getPath() === '/') {
            return $this;
        }
        return null;
    }
}
