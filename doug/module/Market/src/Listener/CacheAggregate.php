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
    const OUTPUT_CACHE_KEY  = 'market-index-index';
    const RECACHE_KEY       = 'recache-this-key';


    protected $cache;

    public function setCache($cache)
    {
        $this->cache = $cache;
    }

    public function attach(EventManagerInterface $e, $priority = 1)
    {
        $priority = 99;
        //*** attach a series of listeners using the shared manager
        $shared = $e->getSharedManager();
        //*** attach a listener to get the page view from cache
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH, [$this, 'getPageViewFromCache'], $priority);
        //*** attach a listener which listens at the very end of the cycle and check to see if the "mustCache" param has been set
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_FINISH, [$this, 'storePageViewToCache'], $priority);
        //*** attach a listener to clear cache if EVENT_CLEAR_CACHE is triggered
        $this->listeners[] = $shared->attach('*', self::EVENT_CLEAR_CACHE, [$this, 'clearCache'], $priority);
    }
    public function detach(EventManagerInterface $e, $priority = 100)
    {
        // do nothing
    }
    public function clearCache($e)
    {
        //*** complete the logic for this method
        if ($cacheKey = $e->getParam('cacheKey')) {
            $this->cache->removeItem($cacheKey);
            error_log('Removed: ' . $cacheKey);
        }
    }
    //*** configure this to check to see if the "ViewController" has been chosen
    //*** if so, check to see if the response object has been cached and return it
    //*** otherwise set a param "mustCache" to indicate this page view should be cached
    public function getPageViewFromCache(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        $matched    = trim($routeMatch->getMatchedRouteName());
        //*** complete the logic for this method
        if (strpos($matched, 'market/view') === 0) {
            // matched route == market/view/category | market/view/item
            $cacheKey   = str_replace('/', '_', $matched) . '_';
            if ($itemId = $routeMatch->getParam('itemId')) {
                $cacheKey .= 'item_' . $itemId;
            } elseif ($category = $routeMatch->getParam('category')) {
                $cacheKey .= 'category_' . $category;
            }
            if ($this->cache->hasItem($cacheKey)) {
                error_log('Retrieved from Cache: ' . $cacheKey);
                return $this->cache->getItem($cacheKey);
            } else {
                $routeMatch->setParam(self::RECACHE_KEY, $cacheKey);
            }
        }
    }
    public function storePageViewToCache(MvcEvent $e)
    {
        //*** complete the logic for this method
        $routeMatch = $e->getRouteMatch();
        if ($cacheKey = $routeMatch->getParam(self::RECACHE_KEY)) {
            $this->cache->setItem($cacheKey, $e->getResponse());
            error_log('Saved to Cache: ' . $cacheKey);
        }
    }
}
