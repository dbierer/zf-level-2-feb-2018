<?php
namespace Events\Listener;

//*** add "use" statements

class Aggregate implements ListenerAggregateInterface
{

    protected $eventManager;

    public function attach(EventManagerInterface $e, $priority = 100)
    {
        //*** attach "onLog()" as a listener to the modification event using a wildcard identifier
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
