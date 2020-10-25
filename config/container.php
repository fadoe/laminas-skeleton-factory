<?php

declare(strict_types=1);

use Laminas\Mvc\Service\ServiceManagerConfig;
use Laminas\ServiceManager\ServiceManager;

$appConfig = require __DIR__ . '/config.php';

$smConfig = $appConfig['service_manager'] ?? [];
$smConfig = new ServiceManagerConfig($smConfig);

$serviceManager = new ServiceManager();
$smConfig->configureServiceManager($serviceManager);
$serviceManager->setService('ApplicationConfig', $appConfig);

$serviceManager->get('ModuleManager')->loadModules();

// Prepare list of listeners to bootstrap
$listenersFromAppConfig = $appConfig['listeners'] ?? [];
$config = $serviceManager->get('config');
$listenersFromConfigService = $config['listeners'] ?? [];

$listeners = array_unique(array_merge($listenersFromConfigService, $listenersFromAppConfig));

// TODO: doof
$serviceManager->get('Application')->bootstrap($listeners);

return $serviceManager;
