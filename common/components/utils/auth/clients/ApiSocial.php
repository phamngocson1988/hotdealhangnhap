<?php
namespace app\components\utils\auth\clients;

use Yii;
class ApiSocial {
    private $_client;
    
    public $provider;
    public $accessToken;
    public $expires;
    public $token;

    public function __construct($provider) {
        $this->provider = $provider;
        $this->setClient($this->provider);
    }
    
    private function setClient($provider) {
        $collection = Yii::$app->authClientCollection;
        $this->_client = $collection->getClient($provider);
    }
    
    private function getClient() {
        return $this->_client;
    }
    
    private function setApiToken() {
        switch ($this->provider) {
            case 'google':
                $params = [
                    'access_token' => $this->accessToken,
                    'expires_in' => $this->expires,
                    'id_token' => $this->token,
                    'token_type' => 'Bearer'
                ];
                break;
            case 'naver':
                $params = [
                    'access_token' => $this->accessToken,
                    'expires_in' => $this->expires,
                    'refresh_token' => $this->token,
                    'token_type' => 'bearer'
                ];
                break;
            default :
                $params = [
                    'access_token' => $this->accessToken,
                    'expires' => $this->expires
                ];
        }
        $this->_client->setApiToken($params);
    }
    
    public function getApiData()
    {
        $this->setApiToken();
        return $this->_client->getApiData();
    }
}