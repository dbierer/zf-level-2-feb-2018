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
                'paths' => [__DIR__ . '???'],
            ],

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'drivers' => [
                    //*** what is the namespace for the entities?
                    'myDoctrine\entity' => 'doctrine_annotation_driver'
                ]
            ],
        ],
        // NOTE: "connection" and "configuration" would normally go into a /config/autoload/*.local.php file
        'connection' => [
            // default connection name
            'orm_default' => [
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => [
                    //*** enter the appropriate database config
                    'driver'         => '???',
                    'host'           => '???',
                    'dbname'         => '???',
                    'user'           => '???',
                    'password'       => '???',
                    'driver_options' => [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
                ],
            ],
        ],
        'configuration' => [
            // Configuration for service `doctrine.configuration.orm_default` service
            'orm_default' => [
                // metadata cache instance to use. The retrieved service name will
                // be `doctrine.cache.$thisSetting`
                'metadata_cache'    => 'array',

                // DQL queries parsing cache instance to use. The retrieved service
                // name will be `doctrine.cache.$thisSetting`
                'query_cache'       => 'array',

                // ResultSet cache to use.  The retrieved service name will be
                // `doctrine.cache.$thisSetting`
                'result_cache'      => 'array',

                // Hydration cache to use.  The retrieved service name will be
                // `doctrine.cache.$thisSetting`
                'hydration_cache'   => 'array',

                // Mapping driver instance to use. Change this only if you don't want
                // to use the default chained driver. The retrieved service name will
                // be `doctrine.driver.$thisSetting`
                'driver'            => 'orm_default',

                // Generate proxies automatically (turn off for production)
                'generate_proxies'  => true,


                //*** make sure this directory exists and is writeable

                // directory where proxies will be stored. By default, this is in
                // the `data` directory of your application
                'proxy_dir'         => __DIR__ . '/../../../data/DoctrineORMModule/Proxy',

                // namespace for generated proxy classes
                'proxy_namespace'   => 'DoctrineORMModule\Proxy',

                // SQL filters. See http://docs.doctrine-project.org/en/latest/reference/filters.html
                'filters'           => [],

                // Custom DQL functions.
                // You can grab common MySQL ones at https://github.com/beberlei/DoctrineExtensions
                // Further docs at http://docs.doctrine-project.org/en/latest/cookbook/dql-user-defined-functions.html
                'datetime_functions' => [],
                'string_functions' => [],
                'numeric_functions' => [],

                // Second level cache configuration (see doc to learn about configuration)
                'second_level_cache' => [],
            ],
        ],
    ],
];
