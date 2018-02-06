<?php
namespace Login;

use Zend\Mvc\MvcEvent;
use Zend\Db\Adapter\Adapter;

use Login\Model\UsersTable;
use Login\Auth\CustomStorage;
use Login\Security\Password;

//*** add required "use" statements

class Module
{
    const VERSION = '3.0.3-dev';

    public function onBootstrap(MvcEvent $e)
    {
        $em = $e->getApplication()->getEventManager();
        $em->attach(MvcEvent::EVENT_DISPATCH, [$this, 'injectAuthService']);
    }

    public function injectAuthService(MvcEvent $e)
    {
        $layout = $e->getViewModel();
        //*** use service container to retrieve the auth service
        $authService = '???';
        //*** inject auth service into layout
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'services' => [
                //*** define callback which performs BCRYPT password verification
                'login-auth-callback' => function ($hash, $password) {
                    return '???'; //*** ???
                },
            ],
            'factories' => [
                'login-db-adapter' => function ($container) {
                    return new Adapter($container->get('model-primary-adapter-config'));
                },
                //*** define an authentication adapter
                'login-auth-adapter' => function ($container) {
                    return new CallbackCheckAdapter(
                        //*** add these arguments: auth adapter, tablename, identity col, password col and callback
                    );
                },
                'login-auth-storage' => function ($container) {
                    return new CustomStorage($container->get('login-storage-filename'));
                },
                //*** define an authentication adapter
                'login-auth-service' => function ($container) {
                    return new AuthenticationService(
                        //*** need storage and auth adapter as arguments
                },
            ],
        ];
    }
}
