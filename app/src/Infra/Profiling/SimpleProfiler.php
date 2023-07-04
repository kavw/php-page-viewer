<?php

declare(strict_types=1);

namespace PV\Infra\Profiling;

final class SimpleProfiler implements ProfilerInterface
{
    private float $time = 0;
    public function __construct()
    {
        $this->time = hrtime(true);
    }

    public function stop(): float
    {
        return hrtime(true) - $this->time;
    }
}
