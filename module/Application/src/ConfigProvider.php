<?php

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

/**
 * Class ConfigProvider
 * @package Application
 */
class ConfigProvider
{
    /**
     * @return array[]
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'router' => $this->getRouterConfig(),
            'controllers' => $this->getControllerConfig(),
            'view_manager' => $this->getViewManagerConfig(),
        ];
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [];
    }

    /**
     * @return \array[][]
     */
    public function getRouterConfig(): array
    {
        return [
            'routes' => [
                'home' => [
                    'type' => Literal::class,
                    'options' => [
                        'route' => '/',
                        'defaults' => [
                            'controller' => Controller\IndexController::class,
                            'action' => 'index',
                        ],
                    ],
                ],
                'application' => [
                    'type' => Segment::class,
                    'options' => [
                        'route' => '/application[/:action]',
                        'defaults' => [
                            'controller' => Controller\IndexController::class,
                            'action' => 'index',
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return \string[][]
     */
    public function getControllerConfig(): array
    {
        return [
            'factories' => [
                Controller\IndexController::class => InvokableFactory::class,
            ],
        ];
    }

    /**
     * @return array
     */
    public function getViewManagerConfig(): array
    {
        return [
            'display_not_found_reason' => true,
            'display_exceptions' => true,
            'doctype' => 'HTML5',
            'not_found_template' => 'error/404',
            'exception_template' => 'error/index',
            'template_map' => [
                'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
                'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
                'error/404' => __DIR__ . '/../view/error/404.phtml',
                'error/index' => __DIR__ . '/../view/error/index.phtml',
            ],
            'template_path_stack' => [
                __DIR__ . '/../view',
            ],
        ];
    }
}