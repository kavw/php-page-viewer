<?php

namespace PV\App;

use PV\App\Settings\Assertions\IsDir;
use PV\App\Settings\Assertions\IsReadable;
use PV\App\Settings\Assertions\UriPrefix;
use PV\App\Settings\Env;
use PV\App\Settings\Filters\RealPath;
use PV\App\Settings\FrontCache;
use PV\App\Settings\Logger;

final class Settings
{
    public const PAGE_STORAGE_DIR = 'PV_PAGE_STORAGE_DIR';
    public const ROUTE_PREFIX = 'PV_ROUTE_PREFIX';
    public const MEDIA_PREFIX = 'PV_MEDIA_PREFIX';

    //phpcs:disable Squiz.Functions.MultiLineFunctionDeclaration
    public function __construct(
        readonly public Logger $logger = new Logger(),
        readonly public FrontCache $frontCache = new FrontCache(),
        readonly public Env $pageStorageDir = new Env(
            self::PAGE_STORAGE_DIR,
            __DIR__ . '/../../pages',
            filters: [new RealPath()],
            assertions: [new IsDir(), new IsReadable()]
        ),
        readonly public Env $routePrefix = new Env(
            self::ROUTE_PREFIX,
            default: '',
            filters: [new \PV\App\Settings\Filters\UriPrefix()],
            assertions: [new UriPrefix()]
        ),
        readonly public Env $mediaPrefix = new Env(
            self::MEDIA_PREFIX,
            default: '',
            filters: [new \PV\App\Settings\Filters\UriPrefix()],
            assertions: [new UriPrefix()]
        )
    ) {
    }
    //phpcs:enable
}
