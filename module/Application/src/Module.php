<?php

declare(strict_types=1);

namespace Application;

/**
 * Class Module
 * @package Application
 */
class Module
{
    public function getConfig() : array
    {
        $configProvider = new ConfigProvider();
        return $configProvider();
    }
}
