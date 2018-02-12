<?php
//*** SECURITY: BLOCK CIPHER LAB
namespace Encryption;

//*** add correct "use" statements

class Module
{

    const ERROR_OPENSSL = 'ERROR: the OpenSSL extension is not available on this server';
    const ERROR_ALGO    = 'ERROR: none of the preferred algorithms or modes are supported on this server';

    public function getServiceConfig()
    {
        return [
            'services' => [
                //*** create a secure key
                'encryption-key' => '???',
                //*** assign a array of preferred openssl algorithmns in order of preference
                'encryption-algos' => [],
            ],
            'factories' => [
                //*** return a block cipher instance
                'encryption-block-cipher' => function ($container) {
                    //*** add code here
                    return $cipher;
                },
                'encryption-get-config-array' => function ($container) {
                    //*** check to make sure preferred openssl algos exist
                    //*** return an array with params required to create BlockCipher instance
                },
            ],
        ];
    }
}
