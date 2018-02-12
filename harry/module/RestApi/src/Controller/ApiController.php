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
    }
    public function getList()
    {
        //*** define this method
    }
    public function setService(ApiService $service)
    {
        $this->service = $service;
        return $this;
    }
}
