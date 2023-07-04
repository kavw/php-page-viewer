<?php

declare(strict_types=1);

use PV\App\HttpApp;

require_once __DIR__ . '/../vendor/autoload.php';

(function() {
    $logStream = defined('STDOUT') ? STDOUT : fopen('php://stdout', 'wb');

    try {
        HttpApp::create(logStream: $logStream)->run();
    } catch (Throwable $e) {
        if (getenv('PV_MODE') === 'dev') {
            echo "<pre>";
            throw $e;
        }

        if (!isset($_SERVER['SERVER_PROTOCOL'])) {
            http_response_code(500);
        } else {
            header(sprintf(
                "%s 500 %s",
                $_SERVER['SERVER_PROTOCOL'],
                'Something went wrong. Please, try again later.'
            ));
        }

        require_once __DIR__ . '/../src/50x.html';
        fwrite(
            $logStream,
            sprintf(
                "[%s] EMERGENCY: Unhandled exception: %s thrown in %s\n",
                date('c'),
                $e->getMessage(),
                $e->getFile() . ':' . $e->getLine()
            )
        );
    }

})();
