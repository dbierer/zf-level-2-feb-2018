<?php
namespace AuthOauth;

use UnexpectedValueException;
use Zend\Mvc\ {MvcEvent, InjectApplicationEventInterface};
use Zend\Session\Container;

use AuthOauth\Generic\ {User, Hydrator};
use AuthOauth\Adapter\GoogleAdapter;

class Module
{
    //*** attach a 'setLink' to the "LOGIN_VIEW" event (see Login\Controller\IndexController)
    public function onBootstrap(MvcEvent $e)
    {
    }
    //*** set a variable "localeLink" in the view model passed as a parameter
    public function setLink($e)
    {
    }
    public function getModuleDependencies()
    {
        return ['Application','Login'];
    }
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function getServiceConfig()
    {
        return [
            'invokables' => [
                'auth-oauth-user-entity' => User::class,
                'auth-oauth-user-hydrator' => Hydrator::class,
            ],
            'factories' => [
                'auth-oauth-provider-list' => function ($sm) {
                    return array_combine(array_keys($sm->get('auth-oauth-config')),
                                         array_keys($sm->get('auth-oauth-config')));
                },
                'auth-oauth-session-container' => function ($container) {
                    return new Container(__NAMESPACE__);
                },
                //*** assign the google adapter service to AdapterAbstractFactory
            ],
            'abstract_factories' => [
                Factory\AdapterAbstractFactory::class,
            ],
        ];
    }
}
