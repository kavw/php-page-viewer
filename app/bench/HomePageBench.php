<?php

declare(strict_types=1);

namespace PV\Bench;

use PhpBench\Attributes\Iterations;
use PhpBench\Attributes\Revs;
use PhpBench\Attributes\Warmup;
use PV\App\Settings\FrontCache;

#[Revs(100), Warmup(2), Iterations(5)]
final class HomePageBench extends AbstractPage
{
    public function benchHomePage(): void
    {
        $_ENV[FrontCache::ENV_ENABLED] = '0';
        $this->executeRequest('/');
    }

    public function benchHomePageWithFrontCache(): void
    {
        $_ENV[FrontCache::ENV_ENABLED] = '1';
        $this->executeRequest('/');
    }
}