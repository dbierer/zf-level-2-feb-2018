<?php
namespace RestApi;

use Zend\Router\Http\ {Literal,Segment};

return [
    'router' => [
        'routes' => [
            'rest-api' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/api',
                    'defaults' => [
                        'controller' => Controller\ApiController::class,
                    ],
                ],
                'may_terminate' => TRUE,
                'child_routes' => [
					'with-id' => [
						'type'    => Segment::class,
						'options' => [
							'route'    => '/[:id]',
							'constraints' => [
								'id' => '[0-9]+',
							],
						],
					],
					'category' => [
						'type'    => Segment::class,
						'options' => [
							'route'    => '/category[/:category]',
							'constraints' => [
								'category' => '[a-z]+',
							],
						],
					],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\ApiController::class => Controller\Factory\ApiControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\ApiService::class => Service\Factory\ApiServiceFactory::class,
        ],
    ],
    'view_manager' => [
        //*** enable the ability to return a JsonModel
        'strategies' => [
			'ViewJsonStrategy',
		],
    ],
    'access-control-config' => [
        'resources' => [
            'rest-api-api' => 'RestApi\Controller\ApiController',
        ],
        'rights' => [
            'guest' => [
                'rest-api-api' => ['allow' => NULL],
            ],
        ],
    ],
];
