<?php

declare(strict_types=1);

use Laminas\Mvc\Service\ServiceManagerConfig;
use Laminas\ServiceManager\ServiceManager;

$appConfig = require __DIR__ . '/config.php';

$appConfig['service_manager'] = array_merge(
    $appConfig['service_manager'] ?? [],
    $appConfig['dependencies'] ?? [],
);

$serviceManager = new ServiceManager();

$smConfig = $appConfig['service_manager'];
$smConfig = new ServiceManagerConfig($smConfig);
$smConfig->configureServiceManager($serviceManager);

$serviceManager->setService('ApplicationConfig', $appConfig);

// TODO: doof
$serviceManager->get('ModuleManager')->loadModules();

// Prepare list of listeners to bootstrap
$config = $serviceManager->get('config');
$listenersFromAppConfig = $appConfig['listeners'] ?? [];
$listenersFromConfigService = $config['listeners'] ?? [];

$listeners = array_unique(array_merge($listenersFromConfigService, $listenersFromAppConfig));

// TODO: doof
$serviceManager->get('Application')->bootstrap($listeners);

return $serviceManager;
