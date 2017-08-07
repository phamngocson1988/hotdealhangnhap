<?php
namespace app\components\utils\auth\clients;

use yii\authclient\clients\Twitter as pTwitter;
use yii\helpers\ArrayHelper;

class Twitter extends pTwitter
{
    public function parseData($attributes) {
        $data = [
            'id' => $attributes['id'],
            'displayName' => $attributes['name'],
            'email' => ArrayHelper::getValue($attributes, 'email'),
            'photoUrl' => ArrayHelper::getValue($attributes, 'profile_image_url')
        ];
        return $data;
    }
}