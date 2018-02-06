<?php
namespace DefaultLocale;

use DefaultLocale\Middleware\Browser;
use Zend\Mvc\MvcEvent;
//*** add the required "use" statements

class Module
{
    protected $container;
    public function onBootstrap(MvcEvent $e)
    {
        $app             = $e->getApplication();
        $eventManager    = $app->getEventManager();
        $this->container = $app->getServiceManager();
        //*** attach a listener which will dispatch DefaultLocale\Middleware\Browser *after* the Mvc "dispatch" event
    }
    public function handleMiddleware(MvcEvent $e)
    {
        //*** define PSR7 compliant request and response objects using Psr7Bridge classes
        $done     = function ($request, $response) {};
        $result   = (new Browser())($request, $response, $done);
        if ($result) {
            //*** convert the PSR-7 response to a "native" Zend Framework response
            return '???';
        }
    }
}
