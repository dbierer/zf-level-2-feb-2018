<?php
namespace Login;

use Zend\Mvc\MvcEvent;
use Zend\Db\Adapter\Adapter;

use Login\Model\UsersTable;
use Login\Auth\CustomStorage;
use Login\Security\Password;

//*** add required "use" statements
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter;

//*** this is not needed, but it's the storage most often used 
// use Zend\Authentication\Storage\Session;

class Module
{
    const VERSION = '3.0.3-dev';

    //*** NOTE: inject auth service into layout is done using Login\Listener\Aggregate

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                'login-db-adapter' => function ($container) {
                    return new Adapter($container->get('model-primary-adapter-config'));
                },
                //*** define an authentication adapter
                'login-auth-adapter' => function ($container) {
                    return new CallbackCheckAdapter(
                        //*** add these arguments: auth adapter, tablename, identity col, password col and callback
                        $container->get('login-db-adapter'),
                        UsersTable::$tableName,
                        UsersTable::$identityCol,
                        UsersTable::$passwordCol,
                        function ($hash, $password) {return Password::verify($password, $hash);}
                    );
                },
                'login-auth-storage' => function ($container) {
                    return new CustomStorage($container->get('login-storage-filename'));
                },
                //*** define an authentication adapter
                'login-auth-service' => function ($container) {
                    return new AuthenticationService(
                        //*** need storage and auth adapter as arguments
                        $container->get('login-auth-storage'),
                        $container->get('login-auth-adapter'));
                },
            ],
        ];
    }
}
