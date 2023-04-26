<?php

declare(strict_types=1);

namespace PV\App\Document\Routes\Item;

use PV\App\Document\DocumentRepoInterface;
use PV\App\Exceptions\NotFoundException;
use PV\Infra\Http\Server\Request\SimpleRequestInterface;
use PV\Infra\Http\Server\Response\SimpleResponseInterface;
use PV\Infra\Http\Server\Router\RouteHandlerInterface;
use PV\Infra\View\RendererFactoryInterface;
use PV\Infra\View\RenderInterface;

final class ItemController implements RouteHandlerInterface
{
    private const MATCH_REGEX = '#^/(fs|db)/[^/]+$#';
    public const NAME = 'doc-fs-item';

    public function __construct(
        readonly private DocumentRepoInterface $documentRepo,
        readonly private RenderInterface $render,
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(SimpleRequestInterface $req): string|SimpleResponseInterface
    {
        $document = $this->documentRepo->findByLink($req->getPath());
        if (!$document) {
            throw new NotFoundException();
        }

        return ($this->render)(new ItemView(document: $document));
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function match(SimpleRequestInterface $req): ?RouteHandlerInterface
    {
        if (preg_match(self::MATCH_REGEX, $req->getPath())) {
            return $this;
        }
        return null;
    }

    public function link(array $params = []): string
    {
        if (!isset($params['link'])) {
            throw new \InvalidArgumentException(
                "It needs 'link' key"
            );
        }

        return $params['link'];
    }
}
