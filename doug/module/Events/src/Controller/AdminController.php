<?php
namespace Events\Controller;

use Events\Traits\ {EventTableTrait, RegTableTrait};
use Events\Model\ {EventTable, RegistrationTable, AttendeeTable};
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AdminController extends AbstractActionController
{

    use EventTableTrait;
    use RegTableTrait;

    public function indexAction()
    {
        $eventId = $this->params('event');
        if ($eventId) {
            return $this->listRegistrations($eventId);
        }
        $events = $this->eventTable->findAll();
        $viewModel = new ViewModel(array('events' => $events));
        return $viewModel;
    }

    protected function listRegistrations($eventId)
    {
        $registrations = $this->regTable->findAllForEvent($eventId);
        $viewModel = new ViewModel(array('registrations' => $registrations));
        $viewModel->setTemplate('events/admin/list.phtml');
        return $viewModel;
    }
}
