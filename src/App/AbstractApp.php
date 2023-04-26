<?php

declare(strict_types=1);

namespace PV\App;

use PV\App\Container\Container;

abstract class AbstractApp
{
    public function __construct(
        readonly protected Container $container
    ) {
    }

    /**
     * @throws \ErrorException
     */
    public function run(): void
    {
        set_error_handler(
            fn (int $errno, string $msg, string $file, int $line)
                => throw new \ErrorException($msg, 0, $errno, $file, $line)
        );

        $this->main();

        restore_error_handler();
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    abstract protected function main(): void;
}
