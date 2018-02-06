<?php
//*** ACL LAB
namespace AccessControl;

use AccessControl\Listener\AclListenerAggregate;
use Zend\Mvc\MvcEvent;

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
                AclListenerAggregate::class => function ($container) {
                    //*** inject the service container
                    //*** return the listener aggregate
                    return $aggregate;
                },
            ],
        ];
    }

}
