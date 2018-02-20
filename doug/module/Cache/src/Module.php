<?php
//*** CACHE LAB
namespace Cache;

use Zend\Mvc\MvcEvent;
//*** add the appropriate "use" statements
use Zend\Cache\StorageFactory;

class Module
{
    public function getServiceConfig()
    {
        return [
            'services' => [
                'cache-config' => [
                    'adapter' => [
                        //*** complete this configuration
                        'name'      => 'filesystem',
                        'options'   => ['ttl' => 3600,
                        'cache_dir' => realpath(__DIR__ . '/../../../data/cache')],
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
                    $config = $container->get('cache-config');
                    //error_log(__METHOD__ . ':' . var_export($config, TRUE));
                    return StorageFactory::factory($config);
                },
            ],
        ];
    }
}
