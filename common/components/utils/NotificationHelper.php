<?php
/**
 * Project: quark.
 * Date: 5/20/2016
 * Name: TDT
 */

namespace app\components\utils;

use Yii;
use app\models\quark\data\biz\NotificationHelperBiz;

class NotificationHelper
{
    public static function submit($data)
    {
        $dataPost = new NotificationHelperBiz();
        $url = Yii::$app->params['notification_url'];
        $dataPost->setFromUser($data['from_user']);
        $dataPost->setOperator($data['action']);
        $dataPost->setToUser($data['to_user']);
        $dataPost->setQuarkId($data['to_quark']);
        $dataPost->setBrandId($data['to_brand']);
        $dataPost->setValueBand(0);

        return self::curlRequest($url, $dataPost->toArray());
    }
    
    public static function curlRequest($url, $post = array(), $options = array())
    { 
        $defaults = array( 
            CURLOPT_HEADER => 0, 
            CURLOPT_URL => $url, 
            CURLOPT_FRESH_CONNECT => 1, 
            CURLOPT_RETURNTRANSFER => 1, 
            CURLOPT_FORBID_REUSE => 1, 
            CURLOPT_TIMEOUT => 1, 
        );

        $dataPost = array();
        if(!empty($post)) {
            $dataPost = array(
                CURLOPT_POST => 1, 
                CURLOPT_POSTFIELDS => http_build_query($post) ,
            );
        }

        $ch = curl_init(); 
        curl_setopt_array($ch, $options + $defaults + $dataPost); 
        if( ! $result = curl_exec($ch)) 
        { 
            $result = curl_error($ch);
        } 
        curl_close($ch); 
        return $result; 
    } 
}