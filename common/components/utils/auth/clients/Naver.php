<?php
namespace app\components\utils\auth\clients;

use yii\authclient\OAuth2;
use yii\helpers\ArrayHelper;

class Naver extends OAuth2
{
    /**
     * @inheritdoc
     */
    public $authUrl = 'https://nid.naver.com/oauth2.0/authorize';
    /**
     * @inheritdoc
     */
    public $tokenUrl = 'https://nid.naver.com/oauth2.0/token';
    /**
     * @inheritdoc
     */
    public $apiBaseUrl = 'https://apis.naver.com/nidlogin';
    
    /**
     * @inheritdoc
     */
    protected function initUserAttributes()
    {
        $headers = ['Authorization: Bearer ' . $this->accessToken->token, 'content_type' => 'xml', 'state' => $this->accessToken->token];
        return $this->api('nid/getUserProfile.xml', 'XML', [], $headers);
    }
    
    public function parseData($attributes) {
        $attributes = $attributes['response'];
        if (!$attributes) {
            return null;
        }
        $data = [
            'id' => $attributes['id'],
            'displayName' => $attributes['name'],
            'email' => ArrayHelper::getValue($attributes, 'email'),
            'photoUrl' => ArrayHelper::getValue($attributes, 'profile_image')
        ];
        return $data;
    }
    /**
     * @inheritdoc
     */
    protected function convertXmlToArray($xml)
    {
        if (!is_object($xml)) {
            $xml = simplexml_load_string($xml, null, LIBXML_NOCDATA);
        }
        $result = (array) $xml;
        foreach ($result as $key => $value) {
            if (is_object($value)) {
                $result[$key] = $this->convertXmlToArray($value);
            }
        }
        return $result;
    }
    
    public function logout()
    {
        return $this->removeState('token');
    }
    
    public function setApiToken($params) {
        $token = $this->createToken(['params' => $params]);
        $this->setAccessToken($token);
    }
    
    public function getApiData()
    {
        $data = $this->initUserAttributes();
        return $this->parseData($data);
    }
}