<?php
namespace Login\Model;

use Application\Model\ {AbstractTable, AbstractModel};
use Login\Security\Password;
use Zend\Hydrator\ClassMethods;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

class UsersTable extends AbstractTable
{

    public static $tableName = 'users';
    public static $identityCol = 'email';
    public static $passwordCol = 'password';
    public function save(AbstractModel $user)
    {
        $password = $user->getPassword();
        //*** save the password as a hash
        $data = $user->extract();
        return $this->tableGateway->insert($data);
    }
}
