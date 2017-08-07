<?php
namespace app\components\utils;
use Yii;

class KCookieUtil
{
	public static function setCookie($key, $value){
		$cookieParams = Yii::$app->session->getCookieParams();
		$cookie = new \yii\web\Cookie([
            'name' => $key,
            'value' => $value,
			'domain' => $cookieParams['domain'],
    		'expire' => EXPIRE_TIME
		]);
        Yii::$app->getResponse()->getCookies()->add($cookie);
	}
	public static function getCookie($key){
        if(!empty(Yii::$app->request->cookies[$key])){
            return Yii::$app->request->cookies[$key]->value;
        }
        else{
            return null;
        }
	}
	
}
?>