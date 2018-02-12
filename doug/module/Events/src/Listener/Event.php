<?php
namespace Events\Listener;

use Zend\EventManager\Event as ZendEvent;

class Event extends ZendEvent
{
    //*** define a constant representing "modification" event
    const EVENT_MODIFICATION = 'events.event.modification';
}
