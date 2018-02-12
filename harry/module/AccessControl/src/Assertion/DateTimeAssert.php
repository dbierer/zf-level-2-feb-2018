<?php
namespace AccessControl\Assertion;

use DateTime;
//*** use the appropriate classes
use Zend\Permissions\Acl\*;

class DateTimeAssert implements AssertionInterface
{
    protected $startTime;
    protected $stopTime;
    public function __construct(\DateTime $start, \DateTime $stop)
    {
        $this->startTime = $start;
        $this->stopTime = $stop;
    }

    //*** define the correct signature for the assert() method
    public function assert(//*** ???)
    {
        $now   = new DateTime('now');
        return (($this->startTime <= $now) && ($now <= $this->stopTime));
    }
}
