<?php
namespace AccessControl\Listener;

use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Application\Traits\ServiceContainerTrait;

class AclListenerAggregate implements ListenerAggregateInterface
{

    const DEFAULT_ACTION = 'index';
    const DEFAULT_CONTROLLER = 'Market\Controller\IndexController';

    use ServiceContainerTrait;

    public function attach(EventManagerInterface $e, $priority = 100)
    {
        //*** attach the "checkAcl" and "injectAcl" listeners to the MVC "dispatch" event using the shared manager
    }
    public function detach(EventManagerInterface $e, $priority = 100)
    {
        // do nothing
    }
    public function injectAcl(MvcEvent $e)
    {
        $acl = $this->serviceContainer->get('access-control-market-acl');
        $layout = $e->getViewModel();
        $layout->setVariable('acl', $acl);
    }
    public function checkAcl(MvcEvent $e)
    {
        //*** get ACL and auth service
        // pull resource and rights from route match
        $match = $e->getRouteMatch();
        $rights = $match->getParam('action');
        $resource = $match->getParam('controller');
        // get role
        if ($authService->hasIdentity()) {
            $role = $authService->getIdentity()->getRole() ?? 'guest';
        } else {
            $role = 'guest';
        }
        $denied = TRUE;
        //*** make sure controller which is matched is in the list of resources
        //*** if not, set $denied == FALSE
        if ($denied && $resource != self::DEFAULT_CONTROLLER) {
            $match->setParam('controller', self::DEFAULT_CONTROLLER);
            $match->setParam('action', self::DEFAULT_ACTION);
        }
        // otherwise: do nothing
    }
}
