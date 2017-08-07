<?php
namespace app\components\utils\auth\clients;

use yii\authclient\clients\Facebook as pFacebook;
use yii\helpers\ArrayHelper;

class Facebook extends pFacebook
{
    const GRAPH_URL = 'http://graph.facebook.com/%s/picture?width=%d&height=%d';
    public function parseData($attributes) {
        $data = [
            'id' => $attributes['id'],
            'displayName' => $attributes['name'],
            'email' => ArrayHelper::getValue($attributes, 'email'),
        ];
        $data['photoUrl'] = $this->apiBaseUrl . '/' . $attributes['id'] . "/picture?width=150&height=150";
        return $data;
    }
    
    public function logout() {
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