<?php
namespace AccessControl\Listener;

use AccessControl\Acl\MarketAcl;
use Zend\Authentication\AuthenticationService;

use Zend\Mvc\MvcEvent;
use Zend\EventManager\ {EventManagerInterface,ListenerAggregateInterface};
use Zend\Permissions\Acl\Acl;

class AclListenerAggregate implements ListenerAggregateInterface
{

    const DEFAULT_ROLE = 'guest';
    const DEFAULT_ACTION = 'index';
    const DEFAULT_CONTROLLER = 'Market\Controller\IndexController';
    const DEFAULT_REDIRECT = 'http://onlinemarket.work/market';

    public function attach(EventManagerInterface $e, $priority = 100)
    {
        //*** attach the "checkAcl" and "injectAcl" listeners to the MVC "dispatch" event using the shared manager
        $shared = $e->getSharedManager();
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH,  [$this, 'injectAcl'], 2);
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH,  [$this, 'checkAcl'], 999);
    }
    public function detach(EventManagerInterface $e, $priority = 100)
    {
        // do nothing
    }
    public function injectAcl(MvcEvent $e)
    {
        $layout = $e->getViewModel();
        $layout->setVariable('acl', $this->acl);
    }
    public function checkAcl(MvcEvent $e)
    {
        // pull resource and rights from route match
        $match = $e->getRouteMatch();
        $rights = $match->getParam('action');
        $resource = $match->getParam('controller');
        // get role
        if ($this->authService->hasIdentity()) {
            $role = $this->authService->getIdentity()->getRole() ?? self::DEFAULT_ROLE;
        } else {
            $role = self::DEFAULT_ROLE;
        }
        $denied = TRUE;
        //*** make sure controller which is matched is in the list of resources
        if ($this->acl->hasResource($resource)) {
            if ($this->acl->hasRole($role)) {
                if ($this->acl->isAllowed($role, $resource, $rights)) {
                    $denied = FALSE;
                }
            }
        }
        //*** if not, set $denied == FALSE
        if ($denied && $resource != self::DEFAULT_CONTROLLER) {
            $response = $e->getResponse();
            $response->getHeaders()->addHeaderLine('Location', self::DEFAULT_REDIRECT);
            $response->setStatusCode(302);
            return $response;
        }
        // otherwise: do nothing
    }
    public function setAcl(Acl $acl)
    {
        $this->acl = $acl;
        return $this;
    }
    public function setAuthService(AuthenticationService $svc)
    {
        $this->authService = $svc;
        return $this;
    }
}
