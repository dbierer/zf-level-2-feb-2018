<?php
namespace Events;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;
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
                Controller\AdminController::class  => function ($container, $requestedName) {
                    $controller = new $requestedName();
                    $controller->setEventTable($container->get(Model\EventTable::class));
                    $controller->setRegTable($container->get(Model\RegistrationTable::class));
                    return $controller;
                },
                Controller\SignupController::class => function ($container, $requestedName) {
                    $controller = new $requestedName();
                    $controller->setEventTable($container->get(Model\EventTable::class));
                    $controller->setRegTable($container->get(Model\RegistrationTable::class));
                    $controller->setAttendeeTable($container->get(Model\AttendeeTable::class));
                    return $controller;
                },
            ],
        ];
    }
    public function getServiceConfig()
    {
        return [
            'aliases' => [
                'events-db-adapter' => 'model-primary-adapter',
            ],
            'factories' => [
                'events-reg-data-filter' => function ($sm) {
                    $filter = new Filter\FilterChain();
                    $filter->attach(new Filter\StringTrim())
                        ->attach(new Filter\StripTags());
                    return $filter;
                },
                //*** define a single abstract factory to build these table classes
                /*
                Model\EventTable::class => function ($container, $requestedName) {
                    $table = new $requestedName();
                    $table->setTableGateway($container->get('events-db-adapter'));
                    return $table;
                },
                Model\RegistrationTable::class => function ($container, $requestedName) {
                    $table = new $requestedName();
                    $table->setTableGateway($container->get('events-db-adapter'));
                    return $table;
                },
                Model\AttendeeTable::class => function ($container, $requestedName) {
                    $table = new $requestedName();
                    $table->setTableGateway($container->get('events-db-adapter'));
                    return $table;
                },
                */
            ],
            'abstract_factories' => [
                //*** define an abstract factory which sets the tableGateway property for all table module classes
                'events-table-abstract-factory' => new class () implements AbstractFactoryInterface {
                    public function canCreate(ContainerInterface $container, $requestedName)
                    {
                        return (substr($requestedName,-5)=='Table');
                    }
                    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
                    {
                        $table     = new $requestedName();
                        $table->setTableGateway($container->get('events-db-adapter'));
                        return $table;
                    }
                },

            ],
        ];
    }
}