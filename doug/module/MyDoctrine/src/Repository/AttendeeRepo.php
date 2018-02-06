<?php
namespace MyDoctrine\Repository;

//*** need "use" statements

class AttendeeRepo extends EntityRepository
{

    /**
     * @param Application\Entity\Registration $regEntity
     * @param string $nameOnTicket
     * @return Application\Entity\Attendee
     */
    public function persist($regEntity, $nameOnTicket)
    {
        //*** need code to save to the database
        //*** don't forget to flush!!!
        return $attendee;
    }
}
