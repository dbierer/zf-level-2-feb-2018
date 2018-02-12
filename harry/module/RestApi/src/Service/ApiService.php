<?php
namespace RestApi\Service;

use Zend\Db\Sql\Sql;

class ApiService
{

    use TableTrait;

    //*** define the logic to retrieve listings without ID
    public function fetchAll()
    {
    }
    //*** define the logic to retrieve listings with ID
    public function fetchById($id)
    {
    }
}
