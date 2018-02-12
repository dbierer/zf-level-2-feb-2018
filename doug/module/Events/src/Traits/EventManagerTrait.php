<?php
namespace Events\Traits;

use Zend\EventManager\EventManagerInterface;

trait EventManagerTrait
{
    protected $eventManager;
    public function setEventManager(EventManagerInterface $em)
    {
        $this->eventManager = $em;
    }
}
