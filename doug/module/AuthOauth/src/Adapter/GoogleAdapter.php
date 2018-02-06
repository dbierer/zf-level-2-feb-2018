<?php
namespace AuthOauth\Adapter;

use Exception;
use AuthOauth\Generic\Constants;
use Zend\Authentication\Exception\InvalidArgumentException;
use Zend\Authentication\Exception\RuntimeException;
use Zend\Authentication\Result;
use League\OAuth2\Client\Provider\Google as GoogleProvider;

class GoogleAdapter extends BaseAdapter
{
    
    const PROVIDER_NAME = 'google';    
    protected $provider;
    
    public function __construct($params)
    {
        $this->provider = new GoogleProvider($params);
        $this->callback = $this->callback . '/' . self::PROVIDER_NAME;
    }
    
    /**
     * Authenticate using logic provided by the PHP League Google Client docs
     *
    */
    public function authenticate()
    {
        $result = FALSE;
        try {
            $identity = $this->process();
            if (!$identity) {
                $result = new Result(Result::FAILURE, $identity, [self::ERROR_AUTH]);
            } else {
                $result = new Result(Result::SUCCESS, $identity, [self::SUCCESS_AUTH]);
                // store identity
                $this->getAuthService()->getStorage()->write($result->getIdentity());
            }
        } catch (Exception $e) {
            error_log(__METHOD__ . ':' . __LINE__ . ':' . $e->getMessage());
            $result = new Result(Result::FAILURE_UNCATEGORIZED, NULL, [$e->getMessage()]);
        }
        return $result;
    }

    public function process()
    {
        
        //*** pull in the logic as defined in the PHP League documentation for the Google client
        //*** see the documentation here: https://github.com/thephpleague/oauth2-google
        //*** use "$this->session" in place of "$_SESSION"
        
        $identity = $this->getUserEntity();
        
        // Use this to interact with an API on the users behalf
        $identity->setToken($token->getToken());

        // Use this to get a new access token if the old one expires
        $identity->setRefresh($token->getRefreshToken());

        // Number of seconds until the access token will expire, and need refreshing
        $identity->setExpiration($token->getExpires());
        
        // Set info from $response and return
        return $this->setCustomInfo($identity, $response);
    }

    /**
     * Sets information which is specific to google
     * 
     */
    public function setCustomInfo($identity, $response)
    {
        $identity->setId($response->getId());
        $identity->setEmail($response->getEmail());
        $identity->setOauthEmail($response->getEmail());
        $identity->setDisplayName($response->getName());
        $identity->setUserName(strtolower(substr($response->getFirstName(), 0, 1) . substr($response->getLastName(), 0, 7)));
        $identity->setProvider(self::PROVIDER_NAME);
        return $identity;
    }
    
}
