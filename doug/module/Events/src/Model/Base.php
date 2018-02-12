<?php
namespace Events\Model;

use Events\Traits\EventManagerTrait;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

class Base implements TableGatewayInterface
{
    //*** EVENTMANAGER LISTENER AGGREGATE LAB: add methods to get and set the event manager
    use EventManagerTrait;

    public static $tableName;
    protected $tableGateway;

    //*** ABSTRACT FACTORIES LAB: need to create a constructor which calls this method
    public function setTableGateway(Adapter $adapter)
    {
        $this->tableGateway = new TableGateway(static::$tableName, $adapter);
    }
}
