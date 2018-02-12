<?php
namespace Events\Model;

use Zend\Db\Adapter\Adapter;
interface TableGatewayInterface
{
    public function setTableGateway(Adapter $adapter);
}
