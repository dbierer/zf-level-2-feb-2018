<?php
namespace Events;

use PDO;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    //*** ABSTRACT FACTORIES LAB: define an abstract factory to create the three table model classes
    //    See: Event\Module class
    //*** EVENTMANAGER LISTENER AGGREGATE LAB: define listener aggregate as a container service
    'service_manager' => [
        'factories' => [
            Listener\Aggregate::class => Listener\Factory\AggregateFactory::class,
        ],
    ],
    //*** EVENTMANAGER LISTENER AGGREGATE LAB: register the aggregate as a listener
    'listeners' => [
       Listener\Aggregate::class,
    ],  
    'router' => [
        'routes' => [
            'events' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/events',
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
    //*** ACL LAB
    'access-control-config' => [
        'resources' => [
            //*** define a resource 'events-index' which points to 'Events\Controller\IndexController'
            //*** define a resource 'events-admin' which points to 'Events\Controller\AdminController',
            //*** define a resource 'events-sign' which points to 'Events\Controller\SignupController',
            //*** NAVIGATION LAB: assign menu items as resources
            'menu-events'        => 'menu-events',
            'menu-events-signup' => 'menu-events-signup',
            'menu-events-admin'  => 'menu-events-admin',
        ],
        'rights' => [
            'guest' => [
                //*** for the 'events-index' resource, guests should be allowed any action
                //*** for the 'events-sign' resource, guests should be allowed any action
                //*** NAVIGATION LAB: guest can see the 'menu-events' and 'menu-events-signup' menu items
                'menu-events'        => ['allow' => NULL],
                'menu-events-signup' => ['allow' => NULL],
            ],
            'admin' => [
                //*** for the 'events-admin' resource, admin should be allowed any action
                //*** NAVIGATION LAB: admin can see the 'menu-admin' item
                'menu-events-admin' => ['allow' => NULL, 'assert' => 'access-control-datetime-assert'],
            ],
        ],
    ],
];
