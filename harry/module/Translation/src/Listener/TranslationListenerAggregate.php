<?php
namespace Translation\Listener;

use Locale;
use Application\Traits\ServiceManagerTrait;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

class TranslationListenerAggregate implements ListenerAggregateInterface
{
    use ServiceManagerTrait;
    public function attach(EventManagerInterface $e, $priority = 100)
    {
        $shared = $e->getSharedManager();
        //*** make the appropriate attachments here
    }
    public function detach(EventManagerInterface $e, $priority = 100)
    {
        // do nothing
    }

    //*** define a listener which sets locale based on a user identity property "locale"

    //*** define a listener which sets locale based on an Event parameter

    //*** define a listener which sets a variable "localeLink" on the view model obtained as a parameter "viewModel"

}
