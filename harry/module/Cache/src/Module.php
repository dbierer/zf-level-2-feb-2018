<?php
//*** CACHE LAB
namespace Cache;

use Zend\Mvc\MvcEvent;
//*** add the appropriate "use" statements

class Module
{
    public function getServiceConfig()
    {
        return [
            'services' => [
                'cache-config' => [
                    'adapter' => [
                        //*** complete this configuration
                        'name'      => ???,
                        'options'   => ['ttl' => 3600],
                        'cache_dir' => ???,
                    ],
                    'plugins' => [
                        // override in /config/autoload/development.local.php
                        'exception_handler' => ['throw_exceptions' => FALSE],
                    ],
                ],
            ],
            'factories' => [
                'cache-adapter' => function ($container) {
                    //*** what to return?
                },
            ],
        ];
    }
}
