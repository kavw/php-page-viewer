<?php

declare(strict_types=1);

namespace PV\Infra\Logger;

use Psr\Log\LoggerInterface;

final readonly class SimpleStreamLogger implements LoggerInterface
{
    public function __construct(
        /**
         * @var resource|null $stream
         */
        private mixed $stream,
        private LogLevel $logLevel = LogLevel::INFO,
    ) {
    }

    public function log($level, \Stringable|string $message, array $context = []): void
    {
        if (!is_resource($this->stream)) {
            return;
        }

        if (!$level instanceof LogLevel) {
            throw new \InvalidArgumentException(
                sprintf("Needs enum %s as argument", LogLevel::class)
            );
        }

        if ($this->logLevel->value > $level->value) {
            return;
        }

        fwrite(
            $this->stream,
            sprintf(
                "[%s] %s: %s %s\n",
                date('c'),
                $level->name,
                $message,
                $context ? json_encode($context) : ''
            )
        );
    }

    public function debug(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

    public function info(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    public function notice(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    public function warning(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    public function error(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    public function alert(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    public function critical(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    public function emergency(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }
}
