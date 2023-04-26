<?php

declare(strict_types=1);

namespace PV\Bench;

use PhpBench\Attributes\Iterations;
use PhpBench\Attributes\Revs;
use PhpBench\Attributes\Warmup;

#[Revs(100), Warmup(2), Iterations(5)]
final class NotFoundPageBench extends AbstractPage
{
    public function benchNotFoundPage(): void
    {
        $this->executeRequest('/' . uniqid('404-'));
    }
}