<?php
namespace MyDoctrine\Controller;

use MyDoctrine\Model\ {EventTable, RegistrationTable, AttendeeTable};
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Filter;

class SignupController extends AbstractActionController
{
    //*** use the RepoTrait

    protected $regDataFilter;
    public function indexAction()
    {
        $eventId = (int) $this->params('event');
        if ($eventId) {
            return $this->eventSignup($eventId);
        }
        //*** use the event repository to find all events
        $events = $this->eventRepo->findAll();
        return new ViewModel(array('events' => $events));
    }

    public function thanksAction()
    {
        return new ViewModel();
    }

    protected function eventSignup($eventId)
    {
        //*** use the event repository to find an event by ID
        $event = $this->eventRepo->findById($eventId);
        if (!$event) {
            return $this->notFoundAction();
        }
        $vm = new ViewModel(array('event' => $event));
        if ($this->request->isPost()) {
            $this->processForm($this->params()->fromPost(), $event);
            $vm->setTemplate('my-doctrine/signup/thanks.phtml');
        } else {
            $vm->setTemplate('my-doctrine/signup/form.phtml');
        }
        return $vm;
    }

    protected function processForm(array $formData, $event)
    {
        $formData = $this->sanitizeData($formData);
        //*** save the registration
        $event->setRegistrations($reg);
        $this->eventRepo->save($event);
        foreach ($formData['ticket'] as $nameOnTicket) {
            //*** save all attendees for this registration
            //*** set the attendee back into the registration entity, and update it

            $attendee = $this->attendeeRepo->persist($reg, $nameOnTicket);
            $reg->setAttendees($attendee);
            $this->registrationRepo->update($reg);
        }
        return true;
    }

    protected function sanitizeData(array $data)
    {
        $clean  = array();
        foreach ($data as $key => $item) {
            if (is_array($item)) {
                foreach ($item as $subKey => $subItem) {
                    $clean[$key][$subKey] = $this->regDataFilter->filter($subItem);
                }
            } else {
                $clean[$key] = $this->regDataFilter->filter($item);
            }
        }
        return $clean;
    }
    public function setRegDataFilter($filter)
    {
        $this->regDataFilter = $filter;
    }
}
