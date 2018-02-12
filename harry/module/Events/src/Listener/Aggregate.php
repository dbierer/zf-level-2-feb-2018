<?php
namespace Events\Listener;

//*** add "use" statements
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;


class Aggregate implements ListenerAggregateInterface
{

    protected $eventManager;

    //*** attach "onLog()" as a listener to the modification event using a wildcard identifier
    public function attach(EventManagerInterface $e, $priority = 100)
    {
        //*** attach "onLog()" as a listener to the modification event using a wildcard identifier
        $shared = $e->getSharedManager();
        $this->listeners[] = $shared->attach('*', Event::MOD_EVENT, [$this, 'onLog']);
    }
    public function detach(EventManagerInterface $e, $priority = 100)
    {
        // do nothing
    }
    public function onLog($e)
    {
        error_log(get_class($e->getTarget()) . ': REGISTRATION ADDED : ' . $e->getParam('registration'));
    }
}
