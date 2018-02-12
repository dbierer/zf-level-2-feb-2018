<?php
namespace Market\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    use ListingsTableTrait;
    public function indexAction()
    {
        $item = $this->listingsTable->findLatest();
        return new ViewModel(['item' => $item]);
    }
}
