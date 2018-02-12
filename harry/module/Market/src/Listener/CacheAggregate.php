<?php
namespace Market\Listener;

use Market\Controller\MarketController;

use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Application\Traits\ServiceContainerTrait;

class CacheAggregate implements ListenerAggregateInterface
{

    const EVENT_CLEAR_CACHE = 'market-event-clear-cache';
    const OUTPUT_CACHE_KEY = 'market-index-index';

    // NOTE: this provides a property $serviceContainer == a service manager container instance
    use ServiceContainerTrait;

    public function attach(EventManagerInterface $e, $priority = 100)
    {
        //*** attach a series of listeners using the shared manager
        //*** attach a listener to clear cache if EVENT_CLEAR_CACHE is triggered
        //*** attach a listener to get the page view from cache
        //*** attach a listener which listens at the very end of the cycle and check to see if the "mustCache" param has been set
    }
    public function detach(EventManagerInterface $e, $priority = 100)
    {
        // do nothing
    }
    public function clearCache($e)
    {
        //*** complete the logic for this method
    }
    //*** configure this to check to see if the "ViewController" has been chosen
    //*** if so, check to see if the response object has been cached and return it
    //*** otherwise set a param "mustCache" to indicate this page view should be cached
    public function getPageViewFromCache(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        $controller = $routeMatch->getParam('controller');
        $action     = $routeMatch->getParam('action');
        //*** complete the logic for this method
    }
    public function storePageViewToCache(MvcEvent $e)
    {
        //*** complete the logic for this method
    }
}
