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
                Controller\AdminController::class => InvokableFactory::class,
                Controller\SignupController::class => function ($container, $requestedName) {
                    $controller = new $requestedName();
                    $controller->setRegDataFilter($container->get('my-doctrine-reg-data-filter'));
                    return $controller;
                },
            ],
            'initializers' => [
                //*** inject  all 3 repositories into controller
                'my-doctrine-inject-repos' => function ($container, $instance) {
                    if (method_exists($instance, 'setEventRepo')) {
                        $instance->setEventRepo($container->get(EventRepo::class));
                        $instance->setAttendeeRepo($container->get(AttendeeRepo::class));
                        $instance->setRegistrationRepo($container->get(RegistrationRepo::class));
                    }
                },                        
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
                RegistrationRepo::class => function ($sm) {
                    $em = $sm->get('doctrine.entitymanager.orm_default');
                    return new RegistrationRepo($em, $em->getClassMetadata('MyDoctrine\Entity\Registration'));
                },
                AttendeeRepo::class => function ($sm) {
                    $em = $sm->get('doctrine.entitymanager.orm_default');
                    return new AttendeeRepo($em, $em->getClassMetadata('MyDoctrine\Entity\Attendee'));
                },
            ],
        ];
    }
}

