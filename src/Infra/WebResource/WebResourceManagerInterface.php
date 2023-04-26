<?php

declare(strict_types=1);

namespace PV\Infra\WebResource;

interface WebResourceManagerInterface
{
    public function media(string $path): string;
}
