<?php
/**
 * Project: quark.
 * Date: 3/1/2016
 */

namespace app\components\utils;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use Yii;

/**
 * @author Thuyet Dam
 */
class PointHelper
{
    public static function getPointTotalItems($total) {
        if (!is_numeric($total)) {
            return false;
        }
        $total_case = (int) (($total - 1) / 10);
        $point = 0;
        switch ($total_case) {
            case 0:
                $point = $total / 10;
                break;
            case 1:
                $point = 1 + ((($total - 10) / 10) * 0.9);
                break;
            case 2:
                $point = 1.9 + ((($total - 20) / 10) * 0.8);
                break;
            case 3:
                $point = 2.7 + ((($total - 30) / 10) * 0.7);
                break;
            case 4:
                $point = 3.4 + ((($total - 40) / 10) * 0.6);
                break;
            case 5:
                $point = 4 + ((($total - 50) / 10) * 0.5);
                break;
            case 6:
                $point = 4.5 + ((($total - 60) / 10) * 0.4);
                break;
            case 7:
                $point = 4.9 + ((($total - 70) / 10) * 0.3);
                break;
            case 8:
                $point = 5.2 + ((($total - 80) / 10) * 0.2);
                break;
            default:
                $point = 5.4 + ((($total - 90) / 10) * 0.1);
                break;
        }

        return $point;
    }
}