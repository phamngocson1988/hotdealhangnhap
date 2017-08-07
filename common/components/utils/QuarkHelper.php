<?php
/**
 * Project: quark.
 * Date: 3/1/2016
 */

namespace app\components\utils;

use app\models\quark\data\biz\ValueBandQuarkBiz;
use app\models\quark\data\entity\QuarkEntity;
use app\models\quark\data\entity\ValueBandSolrEntity;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use Yii;

class QuarkHelper
{
    public static function mergeFormData($sessionData, $postData)
    {
        $prevTranslation = ArrayHelper::getValue($sessionData, 'translations', []);
        $currentTranslation = ArrayHelper::getValue($postData, 'translations', []);
        //$translationData = array_merge($prevTranslation, $currentTranslation);
        $translationData = [];
        if($currentTranslation) {
            foreach ($currentTranslation as $k => $v) {
                $p = ArrayHelper::getValue($prevTranslation, $k, []);
                $translationData[$k] = array_merge($p, $v);
            }
        }
        else{
            $translationData = $prevTranslation;
        }

        $languages = array_keys(ArrayHelper::getValue($postData, 'list_language', []));

        $translations = [];
        if(!empty($languages)){
            foreach ($translationData as $key => $value) {
                if (in_array($key, $languages)) {
                    $translations[$key] = $value;
                }
            }
        }
        else{
            $translations = $translationData;
        }

        $quark = array_merge($sessionData, $postData);
        $quark['translations'] = $translations;

        return $quark;
    }

    /**
     * @param QuarkEntity[] $quarks
     * @return QuarkEntity[]
     */
    public static function getValueBandLink($quarks)
    {
        /** @var QuarkEntity $item */
        foreach($quarks as &$item){
            $links = [];
            foreach($item->getValueBand() as $band) {
                if($band instanceof ValueBandSolrEntity ){
                    $cat = $band->getCategory();
                    $raw = $band->getRawName();
                    $q = sprintf('[%s]%s', $cat, $raw);
                    if (in_array($band->getLanguage(), ['en', 'ko'])) {
                        $q = sprintf('%s[%s]', $raw, $cat);
                    }
                    $links[] = "<a href='" . $band->getReadUrl() . "'>#$q</a>";
                }
                else{
                    $str = explode(" ", $band);
                    $cat = $str[1];
                    $raw = $str[0];
                    $q = sprintf('[%s]%s', $cat, $raw);
                    if (in_array('ko', ['en', 'ko'])) {
                        $q = sprintf('%s[%s]', $raw, $cat);
                    }
                    //$links[] = "<a href='" . Url::to(['band/index', 'q' => str_replace(" ", "-", $band)]) . "'>#$q</a>";
                    $links[] = "<a href='" . Url::to(['band/index', 'qvb' => str_replace(" ", "-", $band)]) . "'>#$q</a>";
                }
                //$links[$valueBand] = '<a href="' . $link . '">#' . $valueBand . '</a>';
            }

            $item->setListValueBandLink($links);
        }

        return $quarks;
    }

    public static function setDetailLink($quarks)
    {
        /** @var QuarkEntity $item */
        foreach($quarks as &$item){
            $links = [];
            foreach($item->getValueBand() as $valueBand) {
                //$link = \Yii::$app->urlManager->createUrl(['band/index', 'q' => $valueBand]);
                $link = \Yii::$app->urlManager->createUrl(['band/index', 'qvb' => $valueBand]);
                //$links[$valueBand] = $link;
                $links[$valueBand] = '<a href="' . $link . '">#' . $valueBand . '</a>';
            }

            $item->setListValueBandLink($links);
        }

        return $quarks;
    }

    public static function makeValueBandLink($quarks)
    {
        /** @var QuarkEntity $item */
        foreach($quarks as &$item){
            $links = [];
            foreach($item->getValueBandData() as $valueBand) {
                $data = explode('::', $valueBand);

                $orders = KDataUtil::searchValueBandOrder(\Yii::$app->language);
                if($orders[0] == 'valueband') {
                    $vb = $data[0] . ' [' . $data[1] . ']';
                    $ln = $data[0] . '-' . $data[1];
                }
                else {
                    $vb = '[' . $data[0] . '] ' . $data[1];
                    $ln = $data[1] . '-' . $data[0];
                }


                //$link = \Yii::$app->urlManager->createUrl(['band/index', 'q' => $ln]);
                $link = \Yii::$app->urlManager->createUrl(['band/index', 'qvb' => $ln]);
                $links[$vb] = '<a href="' . $link . '">#' . $vb . '</a>';
            }

            $item->setListValueBandLink($links);
        }

        return $quarks;
    }

    public static function makeDetailValueBandLink($quarks)
    {
        /** @var ValueBandQuarkBiz $item */
        foreach($quarks as &$item){
            if($item->getValueBand()) {
                $orders = KDataUtil::searchValueBandOrder(\Yii::$app->language);

                $category = $item->getValueBand()->category;
                $rawName = $item->getValueBand()->raw_name;
                $language = $item->getValueBand()->language;
                //$name = $item->getValueBand()->name;

                // if($orders[0] == 'valueband') {
                if (in_array($language, ['ko', 'en'])) {
                    $link = $rawName . '-' . $category;
                }
                else {
                    $link = $category . '-' . $rawName;
                }
            }
            else {
                $link = '';
            }

            //$link = \Yii::$app->urlManager->createUrl(['band/index', 'q' => $link]);
            $link = \Yii::$app->urlManager->createUrl(['band/index', 'qvb' => $link]);
            $item->setDetailLink($link);
        }

        return $quarks;
    }

    public static function listRole()
    {
        return array(
            '1' => Yii::t('admin1.8', 'Administrator'),
            '2' => Yii::t('admin1.8', 'Quark Administrator'),
            '3' => Yii::t('admin1.8', 'Brand Administrator'),
            '4' => Yii::t('admin1.8', 'Membership Administrator'),
        );
    }
    
    public static function getRoleName($key)
    {
        $list = self::listRole();
        if(isset($list[$key])){
            return $list[$key];
        }
    }
    
     /**
     * @author: NTHanh
     */
    public static function detectedKeywordType($keyword = "")
    {
        $result = false;
        if($keyword){
            if(strpos($keyword, '#') !== false){
                return ltrim($keyword, '#');
            }
        }
        return $result;
    }
     /**
     * Highlight text 
     * @des : hilight a text inside a string
     * @author dbhung
     * @param string 
     * @return string
     */
    
//    public static function highLightText111($string, $text){
//        $text = trim($text);
//        $string = trim($string);
//        $string = str_ireplace( $text, '<b class="bold-text">'.$text.'</b>', $string);
//        return $string;
//    }
    
//     public static function highLightValueBand111($value_band, $text){
//        $temp_band = $value_band;
//        $pos_emp = strpos($value_band, '[');
//        $value_band = str_replace('[', '', $value_band);
//        $value_band = str_replace(']', '', $value_band);      
////        if($value_band == $text){
////            return '<b class="bold-text">'.$temp_band.'</b>';
////        }
//        $tmp = 'Test';// $text = 'test';
//        $text = $tmp;
//        $value_band = str_ireplace( $text, '<b>'.$text.'</b>', $value_band);
//        if($pos_emp == 0){
//            $array = explode(' ', $value_band);
//            $cate = $array[0];
//            unset($array[0]);
//            $cate = '['.$cate.']';
//            $string_return = $cate.' '.implode($array, ' ');
//            $string_return = self::unBoldTag($string_return, 'ko');
//            return str_replace('<b>', '<b class="bold-text">', $string_return);
//        }else if($pos_emp > 0){
//            $array = explode(' ', $value_band);
//            $lenth = count($array);
//            $cate = $array[$lenth - 1];
//            unset($array[$lenth - 1]);
//            $cate = '['.$cate.']';
//            $string_return = implode($array, ' ').' '.$cate;
//            $string_return = self::unBoldTag($string_return, 'other');
//            return str_replace('<b>', '<b class="bold-text">', $string_return);
//        }else{
//            return $temp_band;
//        }
//    }
    
        public static function unBoldTag($value_band, $type){
        $string = $value_band;
        if($type == "ko"){
            $pos = strpos($string, ']');
            $sub_str = substr($string, $pos);
            $pos1 = strpos($sub_str, '<b>');
            $pos2 = strpos($sub_str, '</b>');
            if(!$pos2){
                return $value_band;
            }
            else if(($pos2 && !$pos1) || ($pos1 > $pos2)){
                return $value_band = str_replace(']', '</b>'.']'.'<b>', $value_band);
            }else {
                return $value_band;
            }
        }else{
            $pos = strpos($string, '[');
            $sub_str = substr($string, $pos);
            $pos1 = strpos($sub_str, '<b>');
            $pos2 = strpos($sub_str, '</b>');
            if(!$pos2){
                return $value_band;
            }
            else if(($pos2 && !$pos1) || ($pos1 > $pos2)){
                return $value_band = str_replace('[', '</b>'.'['.'<b>', $value_band);
            }else {
                return $value_band;
            }
        }
    }
    
    public static function my_strip_tags($text){
        $text = preg_replace('/<div><br\/?><\/div>/', '', $text);
        $text = str_replace(array('<p>', '<P>', '<div>', '<DIV>'), '<br>', $text);
        $text = preg_replace('/<[h|H][0-9]+>/', '<br>', $text);
        $text = str_replace(array('</p>', '</P>', '</div>', '</DIV>'), '', $text);
        $text = preg_replace('/<\/[h|H][0-9]+>/', '', $text);
        $text = strip_tags($text, '<br><br/>');
        $text = preg_replace('#(<br */?>\s*)+#i', '<br>', $text);
        $text = preg_replace("/&#?[a-z0-9]+;/i","",$text);
        return $text;
    }
    
    public static function highLightText($string, $hl){   
        if($hl == ""){
            return $string;
        }
        $hl = implode('|',explode(' ',preg_quote($hl)));
        $string = preg_replace("/($hl)/i","<b>$0</b>",$string);
        return $string;
    }
    
    public static function highlightValueBand($string, $hl){
        if($hl == ""){
            return $string;
        }
        $hl = implode('|',explode(' ',preg_quote($hl)));
        $string = preg_replace("/($hl)/i","<b class='highlight'>$0</b>",$string);
        return $string;
    }
    
    public static function highlightValueBandEnity($string, $hl){
        if($hl == ""){
            return $string;
        }
        $hl = trim($hl);     
        $hl = implode('|',explode(' ',preg_quote($hl)));
        $string = preg_replace("/($hl)/i","<b class='highlight'>$0</b>",$string);
        return $string;
    }
    
}