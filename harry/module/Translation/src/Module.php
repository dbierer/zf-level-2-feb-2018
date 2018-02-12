<?php
namespace Translation;

//*** add an appropriate "use" statement for the listener aggregate
use Zend\Mvc\MvcEvent;
use Zend\Cache\StorageFactory;
use Zend\Cache\Storage\Adapter\Filesystem;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function getServiceConfig()
    {
        return [
            'factories' => [
                //*** define the listener aggregate as a service here
            ],

        ];
    }
}
