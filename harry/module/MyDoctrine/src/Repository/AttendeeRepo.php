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
        $attendee = new Attendee();
        $attendee->setRegistration($regEntity);
        $attendee->setName($nameOnTicket);
        $em = $this->getEntityManager();
        $em->persist($attendee);
        //*** don't forget to flush!!!
        $em->flush();
        return $attendee;
    }
}
