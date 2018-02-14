<?php
namespace PrivateMessages\Controller\Factory;

use PrivateMessages\Controller\IndexController;
use PrivateMessages\Form\Send as SendForm;
use PrivateMessages\Model\MessagesTable;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $controller = new IndexController();
        $controller->setTable($container->get(MessagesTable::class));
        $controller->setSendForm($container->get(SendForm::class));
        //*** need to inject the authentication service
        $controller->setAuthService($container->get('login-auth-service'));
        return $controller;
    }
}
