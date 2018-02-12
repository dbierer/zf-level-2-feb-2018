<?php
//*** SECURITY: BLOCK CIPHER LAB
namespace PrivateMessages;

use PrivateMessages\Hydrator\PrivateHydrator;
use PrivateMessages\Model\Message;

use Zend\Mvc\MvcEvent;
use Zend\Crypt\BlockCipher;
use Zend\Crypt\Symmetric\Exception\NotFoundException;

class Module
{

    const ERROR_OPENSSL = 'ERROR: the OpenSSL extension is not available on this server';
    const ERROR_ALGO    = 'ERROR: none of the preferred algorithms or modes are supported on this server';

    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                'private-messages-hydrator' =>
                    function ($container) {
                        //*** assign the block cipher to the private hydrator and return the hydrator
                },
            ],
        ];
    }
}
