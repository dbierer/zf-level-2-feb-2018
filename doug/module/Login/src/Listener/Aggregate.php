<?php
namespace Login\Listener;

use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

class Aggregate implements ListenerAggregateInterface
{

    //*** attach "injectAuthService" as a listener to the MVC dispatch event using a wildcard identifier
    public function attach(EventManagerInterface $e, $priority = 100)
    {
        $shared = $e->getSharedManager();
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH, [$this, 'injectAuthService']);
    }
    public function detach(EventManagerInterface $e, $priority = 100)
    {
        // do nothing
    }
    public function injectAuthService(MvcEvent $e)
    {
        $layout = $e->getViewModel();
        //*** use service container to retrieve the auth service
        $sm = $e->getApplication()->getServiceManager();
        $authService = $sm->get('login-auth-service');
        //*** inject auth service into layout
        $layout->setVariable('authService', $authService);
    }
}

