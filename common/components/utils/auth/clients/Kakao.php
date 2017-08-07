<?php
namespace app\components\utils\auth\clients;

use yii\authclient\OAuth2;
use yii\helpers\ArrayHelper;

class Kakao extends OAuth2
{
    /**
     * @inheritdoc
     */
    public $authUrl = 'https://kauth.kakao.com/oauth/authorize';
    /**
     * @inheritdoc
     */
    public $tokenUrl = 'https://kauth.kakao.com/oauth/token';
    /**
     * @inheritdoc
     */
    public $apiBaseUrl = 'https://kapi.kakao.com/v1';
    
    /**
     * @inheritdoc
     */
    protected function initUserAttributes()
    {
        return $this->api('user/me', 'GET');
    }
    
    public function parseData($attributes) {
        $data = [
            'id' => $attributes['id'],
            'displayName' => ArrayHelper::getValue($attributes, ['properties', 'nickname']),
            'email' => ArrayHelper::getValue($attributes, ['properties', 'email']),
            'photoUrl' => ArrayHelper::getValue($attributes, ['properties', 'thumbnail_image'])
        ];
        return $data;
    }
}