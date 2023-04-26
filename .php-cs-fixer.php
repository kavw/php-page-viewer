<?php

declare(strict_types=1);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setCacheFile(__DIR__ . '/var/.php-cs-fixer.cache');