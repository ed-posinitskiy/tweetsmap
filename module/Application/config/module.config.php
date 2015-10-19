<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return [
    'router'          => [
        'routes' => [
            'home'   => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => 'app.controller.index',
                        'action'     => 'index',
                    ],
                ],
            ],
            'tweets' => [
                'type'          => 'Segment',
                'options'       => [
                    'route'    => '/tweets',
                    'defaults' => [
                        'controller' => 'app.controller.tweets',
                        'action'     => 'index'
                    ]
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'search'  => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/search',
                            'defaults' => [
                                'controller' => 'app.controller.tweets',
                                'action'     => 'search'
                            ]
                        ]
                    ],
                    'history' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/history[/]',
                            'defaults' => [
                                'action' => 'history'
                            ]
                        ]
                    ],
                    'track'   => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/track[/]',
                            'defaults' => [
                                'action' => 'track'
                            ]
                        ]
                    ]
                ]
            ]
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'aliases'            => [
            'translator' => 'MvcTranslator',
        ],
    ],
    'translator'      => [
        'locale'                    => 'en_US',
        'translation_file_patterns' => [
            [
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ],
        ],
    ],
    'controllers'     => [
        'invokables' => [
            'app.controller.index'  => 'Application\\Controller\\IndexController',
            'app.controller.tweets' => 'Application\\Controller\\TweetsController'
        ],
    ],
    'view_manager'    => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map'             => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack'      => [
            __DIR__ . '/../view',
        ],
        'strategies'               => [
            'ViewJsonStrategy',
        ],
    ],
    'doctrine'        => [
        'driver' => [
            'app_entities' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => [
                    __DIR__ . '/../src/Application/Entity'
                ]
            ],
            'orm_default'  => [
                'drivers' => [
                    'Application\Entity' => 'app_entities'
                ]
            ]
        ],
    ]
];
