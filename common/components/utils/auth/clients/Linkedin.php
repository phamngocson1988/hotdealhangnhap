<?php

namespace app\components\utils\auth\clients;

use Yii;
use yii\authclient\clients\LinkedIn as pLinkedin;
use yii\helpers\ArrayHelper;

class Linkedin extends pLinkedin {

    public $attributeNames = [
        'id',
        'email-address',
        'first-name',
        'last-name',
        'public-profile-url',
        'picture-url',
    ];

    public function parseData($attributes) {
        $data = [
            'id' => $attributes['id'],
            'displayName' => $attributes['first-name'].' '.$attributes['last-name'],
            'email' => $attributes['email'],
            'photoUrl' => isset($attributes['picture-url']) ? $attributes['picture-url'] : Yii::$app->params['CDNServer'].'/images/common/icon-avatar-2.png',            
        ];
        return $data;
    }

    public function logout() {
        return $this->removeState('token');
    }

    public function setApiToken($params) {
        $token = $this->createToken(['params' => $params]);
        $this->setAccessToken($token);
    }

    public function getApiData() {
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