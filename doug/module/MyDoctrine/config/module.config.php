<?php
namespace MyDoctrine;

use PDO;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'doctrine' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/doctrine',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => TRUE,
                'child_routes' => [
                    'admin' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/admin[/][:event]',
                            'defaults' => [
                                'controller' => Controller\AdminController::class,
                                'action'     => 'index',
                            ],
                            'constraints' => [
                                'event' => '[0-9]+',
                            ],
                        ],
                    ],
                    'signup' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/signup[/][:event]',
                            'defaults' => [
                                'controller' => Controller\SignupController::class,
                                'action'     => 'index',
                            ],
                            'constraints' => [
                                'event' => '[0-9]+',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [__DIR__ . '/../view'],
    ],
    'doctrine' => [
        // NOTE: "driver" here refers to how is the DBAL mapping done?
        'driver' => [
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'doctrine_annotation_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                //*** where are the entities located in the filesystem?
                'paths' => [__DIR__ . '/../src/Entity'],
            ],

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'drivers' => [
                    //*** what is the namespace for the entities?
                    'MyDoctrine\Entity' => 'doctrine_annotation_driver'
                ]
            ],
        ],
    ],
];
