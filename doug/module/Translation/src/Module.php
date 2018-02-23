<?php
namespace Translation;

//*** add an appropriate "use" statement for the listener aggregate
use Translation\Listener\TranslationListenerAggregate;
use Translation\Factory\AddLocale;

use Login\Form\Login as LoginForm;
use Interop\Container\ContainerInterface;

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
                TranslationListenerAggregate::class => function ($container) {
                    return new TranslationListenerAggregate($container);
                },
            ],
            'delegators' => [
                LoginForm::class => [Factory\AddLocale::class],
            ],
        ];
    }
}
