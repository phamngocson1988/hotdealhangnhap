<?php
/**
 * Project: quark.
 * Date: 4/21/2016
 * Name: TDT
 */

namespace app\components\utils;


class ValueBandHelper
{
    public static function makeValueBandLinkName($tags)
    {
        $orders = KDataUtil::searchValueBandOrder(\Yii::$app->language);
        $category = $tags->category;
        $rawName = $tags->raw_name;
        $name = $tags->name;

        /*
        if($orders[0] == 'valueband') {
            $result = $rawName . '-' . $category;
        }
        else {
            $result = $category . '-' . $rawName;
        }
        */
        if(strpos($name, $category) > 0){
            $result = $rawName . '-' . $category;
        }
        else{
            $result = $category . '-' . $rawName;
        }
        //$result = \Yii::$app->urlManager->createUrl(['band/index', 'q' => $result]);
        $result = \Yii::$app->urlManager->createUrl(['band/index', 'qvb' => $result]);

        return $result;
    }

    public static function makeValueBandName($tags)
    {
        $orders = KDataUtil::searchValueBandOrder(\Yii::$app->language);
        $category = $rawName = '';
        
        if (empty($tags->category) || empty($tags->raw_name)) {
            $qvb = \Yii::$app->request->get('qvb');
            if (!empty($qvb)) {
                $names = explode('-', $qvb);
                $name = $names[0];
		  if (!isset($names[1])) {
                	return $name;
                }
                $cat = $names[1];
                $category = $cat;
                $rawName = $name;            
            }
        }
        else {
            $category = $tags->category;
            $rawName = $tags->raw_name;            
        }

        if($orders[0] == 'valueband') {
            $result = $rawName . ' [' . $category . ']';
        }
        else{
            $result = '[' . $category . '] ' . $rawName;
        }

        return $result;
    }
}