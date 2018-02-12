<?php
namespace Login\Security;

use Zend\Crypt\Password\Bcrypt;

class Password
{
    //*** return a Bcrypt hash
    public static function createHash($plainText)
    {
        //*** place your code here
    }
    //*** verify a password against a hash
    public static function verify($plainText, $hash)
    {
        //*** place your code here
    }
}
