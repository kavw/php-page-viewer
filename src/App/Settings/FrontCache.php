<?php

declare(strict_types=1);

namespace PV\App\Settings;

final class FrontCache
{
    public const ENV_ENABLED = 'PV_FRONT_CACHE_ENABLED';
    public const ENV_TTL = 'PV_FRONT_CACHE_TTL';

    public const DEFAULT_TTL = 300;

    //phpcs:disable Squiz.Functions.MultiLineFunctionDeclaration
    public function __construct(
        readonly public EnvBool $enabled = new EnvBool(
            self::ENV_ENABLED,
            false,
        ),
        readonly public EnvInt $ttl = new EnvInt(
            self::ENV_TTL,
            self::DEFAULT_TTL
        )
    ) {
    }
    //phpcs:enable
}
