<?php

namespace app\components\utils;

/**
 * Reference http://www.w3schools.com/php/func_date_strftime.asp
 */

class KDateFormat
{
    /**
     * @return array
     */
    public static function getDateFormat(){
        return [
            'en' => [
                'locale' => 'en.UTF-8',
                'format' => [
                    'Y.m.d' => '%m.%d.%Y', //18.11.2014
                    'Y-m-d' => '%m-%d-%Y', //18-11-2014
                    'Y.m.d (D)' => '(%a) %m.%d.%Y', //(Fri) 18.11.2014
                    'Y-M-d' => '%b-%d-%Y' //Nov-18-2014
                ]
            ],
            'ko' => [
                'locale' => 'ko_KR.UTF-8',
                'format' => [
                    'Y.m.d' => '%Y.%m.%d', //2014.11.18
                    'Y-m-d' => '%Y-%m-%d', //2014-11-18
                    'Y.m.d (D)' => '%Y.%m.%d (%a)', //2014.11.28 (Fri)
                    'Y-M-d' => '%Y-%b-%d' //2014-Nov-18
                ]
            ],
            'ja' => [
                'locale' => 'ja_JP.UTF-8',
                'format' => [
                    'Y.m.d' => '%Y.%m.%d', //2014.11.18
                    'Y-m-d' => '%Y-%m-%d', //2014-11-18
                    'Y.m.d (D)' => '%Y.%m.%d (%a)', //2014.11.28 (Fri)
                    'Y-M-d' => '%Y-%b-%d' //2014-Nov-18
                ]
            ],
            'vi' => [
                'locale' => 'vi_VN.UTF-8',
                'format' => [
                    'Y.m.d' => '%d.%m.%Y', //18.11.2014
                    'Y-m-d' => '%d-%m-%Y', //18-11-2014
                    'Y.m.d (D)' => '(%a) %d.%m.%Y', //(Fri) 18.11.2014
                    'Y-M-d' => '%d-%b-%Y' //18-Nov-2014
                ]
            ],
        ];
    }
    
    public static function getDateFormatJS($language) {
        $date = [
            'en' => 'mm-dd-yyyy',
            'ko' => 'yyyy-mm-dd',
            'ja' => 'yyyy-mm-dd',
            'vi' => 'dd-mm-yyyy',
        ];
        return isset($date[$language]) ? $date[$language] : $date['en'];
    }
}
