<?php
namespace Market;

use Market\Plugin\Flash;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\View\Helper as ViewHelper;
use Zend\Form\View\Helper as FormHelper;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'market' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/market',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'post' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/post[/]',
                            'defaults' => [
                                'controller' => Controller\PostController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'lookup' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/lookup[/]',
                                    'defaults' => [
                                        'action'     => 'lookup',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'view' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/view',
                            'defaults' => [
                                'controller' => Controller\ViewController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'slash' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/',
                                ],
                            ],
                            'category' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/category[/:category]',
                                    'constraints' => [
                                        'category' => '[A-Za-z0-9]*',
                                    ],
                                    'defaults' => [
                                        'action'     => 'index',
                                    ],
                                ],
                            ],
                            'item' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/item[/:itemId]',
                                    'constraints' => [
                                        'itemId' => '[0-9]*',
                                    ],
                                    'defaults' => [
                                        'action'     => 'item',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'services' => [
            // defined in config/autoload/global.php
            /*
            'categories' => [],
            'market-expire-days' => [],
            'market-captcha-options' => [],
            */
            //*** FILE UPLOAD LAB: define config for file upload validators and filter
            'market-upload-config' => [
                'img_size'   => [],
                'file_size'  => [],
                //*** FILE UPLOAD LAB: add settings as appropriate to RenameUpload filter */
                'rename'     => ['target' => realpath(__DIR__ . '/../../../public/images')],
                'img_url'    => '/images',
            ],
        ],
        'factories' => [
            Form\PostForm::class => Form\Factory\PostFormFactory::class,
            Form\PostFilter::class => Form\Factory\PostFilterFactory::class,
            Flash::class => InvokableFactory::class,
            //*** add missing factory for Market\Listener\CacheAggregate
            Listener\CacheAggregate::class => Listener\Factory\CacheAggregateFactory::class,
            //*** DELEGATORS LAB
            Delegators\AddCsrf::class => Delegators\AddCsrf::class,
        ],
        'delegators' => [
            Form\PostForm::class => [Delegators\AddCsrf::class],
        ], 
    ],
    'listeners' => [
        //*** add entries to represent listeners defined as aggregates
        Listener\CacheAggregate::class,
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\Factory\IndexControllerFactory::class,
            Controller\ViewController::class => Controller\Factory\ViewControllerFactory::class,
            Controller\PostController::class => Controller\Factory\PostControllerFactory::class,
        ],
    ],
    'view_manager' => [
      'template_path_stack' => [__DIR__ . '/../view'],
    ],
    'view_helpers' => [
        'factories' => [
            Helper\LeftLinks::class => InvokableFactory::class,
        ],
        'aliases' => [
            'leftLinks' => Helper\LeftLinks::class,
        ],
    ],
    //*** ACL LAB
    'access-control-config' => [
        'resources' => [

            'market-index' => 'Market\Controller\IndexController',
            //*** define a resource "market-view" which points to 'Market\Controller\ViewController',
            //*** define a resource "market-post" which points to 'Market\Controller\PostController',
            'market-view' => 'Market\Controller\ViewController',
            'market-post' => 'Market\Controller\PostController',

            //*** NAVIGATION LAB: define a market menu item as resources
            //'menu-market-view'  => '???',
            //'menu-market-post'  => '???',
        ],
        'rights' => [
            'guest' => [
                'market-index' => ['allow' => NULL],
                //*** for the "market-view" resource guests are allowed all actions
                'market-view' => ['allow' => NULL],

                //*** NAVIGATION LAB: guests are allowed to see market index and market view menu items
                //'menu-market-index' => ['allow' => NULL],
                //'menu-market-view' => ['allow' => NULL],
            ],
            'user' => [
                //*** for the "market-post" resource users are allowed all actions
                'market-post' => ['allow' => NULL],
                //*** NAVIGATION LAB: users are allowed to see the market post menu item
                //'menu-market-post' => ['allow' => NULL],
            ],
        ],
    ],
];
