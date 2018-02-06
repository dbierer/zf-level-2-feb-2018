<?php
namespace MyDoctrine;

use MyDoctrine\Repository\ {AttendeeRepo, EventRepo, RegistrationRepo};

use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Db\Adapter\Adapter;
use Zend\Filter;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\IndexController::class => InvokableFactory::class,
                //*** inject  all 3 repositories into controller
                Controller\AdminController::class  => function ($container, $requestedName) {
                    $controller = new $requestedName();
                    return $controller;
                },
                //*** inject  all 3 repositories into controller
                Controller\SignupController::class => function ($container, $requestedName) {
                    $controller = new $requestedName();
                    $controller->setRegDataFilter($container->get('my-doctrine-reg-data-filter'));
                    return $controller;
                },
            ],
            'initializers' => [
            ],
        ];
    }
    public function getServiceConfig()
    {
        return [
            'aliases' => [
                'my-doctrine-db-adapter' => 'model-primary-adapter',
            ],
            'factories' => [
                'my-doctrine-reg-data-filter' => function ($sm) {
                    $filter = new Filter\FilterChain();
                    $filter->attach(new Filter\StringTrim())
                           ->attach(new Filter\StripTags());
                    return $filter;
                },
                // NOTE: factory for Doctrine entity manager already exists: "doctrine.entitymanager.orm_default"
                //*** need to define factories for Doctrine repository classes for Registration and Attendee
                EventRepo::class => function ($sm) {
                    $em = $sm->get('doctrine.entitymanager.orm_default');
                    return new EventRepo($em, $em->getClassMetadata('MyDoctrine\Entity\Event'));
                },
            ],
        ];
    }
}

