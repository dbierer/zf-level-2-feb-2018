<?php
namespace RestApi\Service;

use Zend\Db\Sql\Sql;
use Zend\View\Model\JsonModel;

class ApiService
{

    use TableTrait;
    const LINK = 'http://onlinemarket.work/api';

    //*** define the logic to retrieve listings without Listings Table ID
    public function fetchAll()
    {
		$data = $this->table->findAll()->toArray();
		$link = self::LINK;
		return new JsonModel(['_link' => $link, 'data' => $data]);
    }
    //*** define the logic to retrieve listings with Listings Table ID
    public function fetchById($id)
    {
		$link = self::LINK . '/' . $id;
		$data = $this->table->findById($id)->getArrayCopy();
		return new JsonModel(['_link' => $link, 'data' => $data]);
    }
    public function fetchByCategory($category)
    {
		$link = self::LINK . '/category/' . $category;
		$data = $this->table->findByCategory($category)->toArray();
		return new JsonModel(['_link' => $link, 'data' => $data]);
    }
}
