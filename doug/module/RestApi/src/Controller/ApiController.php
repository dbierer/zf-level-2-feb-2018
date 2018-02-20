<?php
//*** REST LAB
namespace RestApi\Controller;

use RestApi\Service\ApiService;
use Zend\View\Model\JsonModel;
use Zend\Mvc\Controller\AbstractRestfulController;

class ApiController extends AbstractRestfulController
{
    protected $service;
    //*** define methods for an HTTP GET with and without an ID
    public function get($id)
    {
        //*** define this method
		return $this->service->fetchById($id);
    }
    public function getList()
    {
        //*** define this method
        $category = $this->getEvent()->getRouteMatch()->getParam('category', NULL);
        if ($category) {
			return $this->service->fetchByCategory($category);
		} else {
			return $this->service->fetchAll();
		}
    }
    public function create($data)
    {
		return new JsonModel(['data'=> $this->getEvent()->getResult()]);
	}
    public function setService(ApiService $service)
    {
        $this->service = $service;
        return $this;
    }
}
