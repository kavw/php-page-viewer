<?php

declare(strict_types=1);

namespace PV\Infra\FileSystem;

final class FileLinesReader
{
    public function read(string $path): \Generator
    {
        if (!is_file($path)) {
            throw new \InvalidArgumentException(
                "Given path {$path} is not a file"
            );
        }

        if (!is_readable($path)) {
            throw new \InvalidArgumentException(
                "Can't read file {$path}"
            );
        }

        $file = null;
        try {
            $file = fopen($path, 'r');
            if (!$file) {
                throw new \RuntimeException("Can't open file '$path'");
            }

            $lock = flock($file, LOCK_SH);
            if (!$lock) {
                throw new \RuntimeException(
                    "Can't acquire a shared lock for the file {$path}"
                );
            }

            while ($line = fgets($file)) {
                yield $line;
            }
        } finally {
            if (is_resource($file)) {
                flock($file, LOCK_UN);
            }
            if (is_resource($file)) {
                fclose($file);
            }
        }
    }
}
