<?php
namespace MyDoctrine\Entity;

//*** need "use" statements

//*** finish the entity annotation
/**
 * @ORM\Table("registration_d")
 */
class Registration
{
    //*** need annotations for each property
    protected $id;

    protected $firstName;

    protected $lastName;

    protected $registrationTime;

    //*** configure a one to many relationship to Attendee
    protected $attendees = array();

    //*** configure a many to one relationship to to Event
    protected $event;

    public function __construct()
    {
        $this->attendees = new ArrayCollection();
    }

    /**
     * @return the $id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return the $firstName
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * @return the $lastName
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * @return the $registrationTime
     */
    public function getRegistrationTime() {
        return $this->registrationTime->format('l, d M Y');
    }

    /**
     * @return the $attendees
     */
    public function getAttendees() {
        return $this->attendees;
    }

    /**
     * @return the back-linked Event entity
     */
    public function getEvent() {
        return $this->event;
    }

    /**
     * @param field_type $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @param field_type $firstName
     */
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    /**
     * @param field_type $lastName
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    /**
     * @param field_type $registrationTime
     */
    public function setRegistrationTime($registrationTime = NULL) {
        if ($registrationTime == NULL) {
            $registrationTime = new \DateTime('now');
        }
        $this->registrationTime = $registrationTime;
    }

    /**
     * @param multitype: $attendees
     */
    public function setAttendees(Attendee $attendee) {
        //*** what goes here?
    }

    /**
     * @param int $event
     */
    public function setEvent($event) {
        $this->event = $event;
    }

}
