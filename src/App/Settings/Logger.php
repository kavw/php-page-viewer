<?php

declare(strict_types=1);

namespace PV\App\Settings;

use PV\Infra\Logger\LogLevel;

final class Logger
{
    public const ENV_LOG_LEVEL = 'PV_LOG_LEVEL';

    public const DEFAULT_LOG_LEVEL = 'INFO';

    public readonly LogLevel $logLevel;

    public function __construct()
    {
        $this->logLevel = LogLevel::fromString(
            (new Env(
                self::ENV_LOG_LEVEL,
                self::DEFAULT_LOG_LEVEL
            ))->val
        );
    }
}
