<?php

declare(strict_types=1);

namespace PV\Infra\Logger;

enum LogLevel: int
{
    case DEBUG = 100;
    case INFO = 200;
    case NOTICE = 250;
    case WARNING = 300;
    case ERROR = 400;
    case CRITICAL = 500;
    case ALERT = 550;
    case EMERGENCY = 600;

    public static function fromString(string $level): self
    {
        return match (strtoupper($level)) {
            self::DEBUG->name => self::DEBUG,
            self::INFO->name => self::INFO,
            self::NOTICE->name => self::NOTICE,
            self::WARNING->name => self::WARNING,
            self::ERROR->name => self::ERROR,
            self::CRITICAL->name => self::CRITICAL,
            self::ALERT->name => self::ALERT,
            self::EMERGENCY->name => self::EMERGENCY,
            default => throw new \InvalidArgumentException("Unknown log level {$level}")
        };
    }
}
