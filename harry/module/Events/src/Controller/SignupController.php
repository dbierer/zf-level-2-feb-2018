<?php
namespace Events\Controller;

use Events\Traits\ {EventTableTrait, RegTableTrait, AttendeeTableTrait};
use Events\Model\ {EventTable, RegistrationTable, AttendeeTable};
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Filter;

class SignupController extends AbstractActionController implements ServiceLocatorAwareInterface
{
    use EventTableTrait;
    use RegTableTrait;
    use AttendeeTableTrait;

    public function indexAction()
    {
        $eventId = (int) $this->params('event');
        if ($eventId) {
            return $this->eventSignup($eventId);
        }
        $events = $this->eventTable->findAll();
        return new ViewModel(array('events' => $events));
    }

    public function thanksAction()
    {
        return new ViewModel();
    }

    protected function eventSignup($eventId)
    {
        $event = $this->eventTable->findById($eventId);
        if (!$event) {
            return $this->notFoundAction();
        }
        $vm = new ViewModel(array('event' => $event));
        if ($this->request->isPost()) {
            $this->processForm($this->params()->fromPost(), $eventId);
            $vm->setTemplate('events/signup/thanks.phtml');
        } else {
            $vm->setTemplate('events/signup/form.phtml');
        }
        return $vm;
    }

    protected function processForm(array $formData, $eventId)
    {
        $formData = $this->sanitizeData($formData);
        $regId = $this->regTable->persist($eventId, $formData['first_name'], $formData['last_name']);
        $ticketData = $formData['ticket'];
        foreach ($ticketData as $nameOnTicket) {
            $this->attendeeTable->persist($regId, $nameOnTicket);
        }
        return true;
    }

    protected function sanitizeData(array $data)
    {
        $clean  = array();
        foreach ($data as $key => $item) {
            if (is_array($item)) {
                foreach ($item as $subKey => $subItem) {
                    $clean[$key][$subKey] = $this->filter->filter($subItem);
                }
            } else {
                $clean[$key] = $this->filter->filter($item);
            }
        }
        return $clean;
    }

}
