<?php

declare(strict_types=1);

namespace PV\Infra\Profiling;

interface ProfilerInterface
{
    public function stop(): float;
}
