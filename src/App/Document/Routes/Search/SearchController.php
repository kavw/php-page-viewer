<?php

declare(strict_types=1);

namespace PV\App\Document\Routes\Search;

use Aws\drs\drsClient;
use PV\App\Document\Routes\Home\HomeView;
use PV\App\Document\Search\SearchRepoInterface;
use PV\Infra\Http\Server\Request\SimpleRequestInterface;
use PV\Infra\Http\Server\Response\SimpleResponseInterface;
use PV\Infra\Http\Server\Router\RouteHandlerInterface;
use PV\Infra\View\RendererFactoryInterface;
use PV\Infra\View\RenderInterface;

final class SearchController implements RouteHandlerInterface
{
    public const NAME = 'search';

    public function __construct(
        readonly private SearchRepoInterface $searchRepo,
        readonly private RenderInterface $render,
    ) {
    }

    public function __invoke(SimpleRequestInterface $req): string|SimpleResponseInterface
    {
        $result = null;
        $term = trim(strip_tags(urldecode((string) $req->getQueryParam('term'))));
        if ($term) {
            $result = $this->searchRepo->find($term);
        }

        $emptyMessage = $term
            ? "There is no documents for the query '{$term}'"
            : "There is no documents for an empty query";

        return ($this->render)(
            new HomeView(
                docs: $result ? $result->items() : [],
                message: !$result || $result->empty() ? $emptyMessage : '',
                searchTerm: $term
            )
        );
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function match(SimpleRequestInterface $req): ?RouteHandlerInterface
    {
        return str_starts_with($req->getPath(), '/search') ? $this : null;
    }

    public function link(array $params = []): string
    {
        return '/search';
    }
}
