<?php

declare(strict_types=1);

namespace PV\Infra\WebResource;

final readonly class WebResourceManager implements WebResourceManagerInterface
{
    public function __construct(
        private string $manifestPath,
        private string $uriPrefix = '',
    ) {
    }

    /**
     * @param string $path
     * @return string
     * @throws \JsonException
     */
    public function media(string $path): string
    {
        return  $this->uriPrefix . '/' . $this->resolvePath($path);
    }

    /**
     * @param string $path
     * @return string
     * @throws \JsonException
     */
    public function resolvePath(string $path): string
    {
        return $this->getManifest()[$path]
            ?? throw new \RuntimeException("Can't resolve path for '{$path}'");
    }

    /**
     * @return array<string, string>
     * @throws \JsonException
     */
    private function getManifest(): array
    {
        static $manifest = null;
        if ($manifest !== null) {
            return $manifest;
        }

        if (!is_readable($this->manifestPath)) {
            throw new \RuntimeException("Can't read manifest {$this->manifestPath}");
        }

        $manifest = json_decode(
            (string) file_get_contents($this->manifestPath),
            associative: true,
            flags: JSON_THROW_ON_ERROR
        );

        /** @var array<string, string> $manifest */
        return $manifest;
    }
}
