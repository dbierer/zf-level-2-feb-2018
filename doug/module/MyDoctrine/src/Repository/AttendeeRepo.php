<?php
namespace MyDoctrine\Repository;

//*** need "use" statements
use Doctrine\ORM\EntityRepository;
use MyDoctrine\Entity\Attendee;

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
        $em->flush();
        return $attendee;
    }
}
