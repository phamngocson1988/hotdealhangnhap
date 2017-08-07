<?php
namespace app\components\utils\auth\clients;

use yii\authclient\clients\GoogleOAuth as pGoogle;
use yii\helpers\ArrayHelper;

class Google extends pGoogle
{
    public function parseData($attributes) {
        $data = [
            'id' => $attributes['id'],
            'displayName' => $attributes['displayName'],
            'email' => ArrayHelper::getValue($attributes, ['emails', '0', 'value']),
            'photoUrl' => ArrayHelper::getValue($attributes, ['image', 'url'])
        ];
        return $data;
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
        try {
            $data = $this->initUserAttributes();
            return $this->parseData($data);
        } catch (\yii\authclient\InvalidResponseException $ex) {
            return null;
        } catch (\yii\base\Exception $ex) {
            return null;
        }
    }
}