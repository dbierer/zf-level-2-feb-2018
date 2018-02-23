<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

/**
 * List of enabled modules for this application.
 *
 * This should be an array of module namespaces used in the application.
 */
return [
    'Zend\Navigation',
    'Zend\Mvc\Plugin\FlashMessenger',
    'Zend\Cache',
    'Zend\Paginator',
    'Zend\Mail',
    'Zend\Router',
    'Zend\Validator',
    'ZendDeveloperTools',
    'DoctrineModule',
    'DoctrineORMModule',
    'PhpSession',
    'Application',
    'Market',
    'Model',
    'Events',
    //*** need to activate this for the Modeling::Doctrine Lab
    'MyDoctrine',
    //*** need to activate this for the Security::Authentication Lab
    'Login',
    //*** need to activate this for the Security::Encryption Lab
    'Encryption',
    'PrivateMessages',
    //*** need to activate this for the Web Services::REST API Lab
    'RestApi',
    //*** need to activate this for the Cross-Cutting-Concerns::Cache Lab
    'Cache',
    //*** need to activate this for the Cross-Cutting-Concerns::ACL Lab
    'AccessControl',
    //*** need to activate this for the Cross-Cutting-Concerns::Oauth Lab
    'AuthOauth',
    //*** need to activate this for the Advanced View::Translation Lab
    'Translation',
    //*** need to activate this for the Middleware::Psr7Bridge Lab
    //'DefaultLocale',
    //*** need to activate this for the Middleware::Listener Lab
    //'Manage',
];
