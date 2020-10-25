<?php

declare(strict_types=1);

use Laminas\Mvc\Application;
use Psr\Container\ContainerInterface;

// Delegate static file requests back to the PHP built-in webserver
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));
require 'vendor/autoload.php';

(function () {
    // Retrieve the service manager
    /** @var ContainerInterface $container */
    $container = require 'config/container.php';

    // Retrieve the application
    /** @var Application $application */
    $application = $container->get('Application');

    // Run the application!
    $application->run();
})();

