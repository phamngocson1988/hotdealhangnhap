<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\Customer;
use yii\helpers\ArrayHelper;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ImportController extends Controller
{
    /**
     * yii import/customer $size
     */
    public function actionCustomer()
    {
        $filePath = Yii::$app->params['file_path'] . '\customer.csv';
           
        $row = 1;
        if (($handle = fopen($filePath, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $facebook = trim(ArrayHelper::getValue($data, 1));
                $name = trim(ArrayHelper::getValue($data, 2));
                $phone = ArrayHelper::getValue($data, 3);
                $email = trim(ArrayHelper::getValue($data, 4));
                $address = ArrayHelper::getValue($data, 5);

                if (!$email) {
                    $alternate = [$facebook, $phone, $name, $address];
                    $alternate = array_filter($alternate);
                    $value = reset($alternate);
                    $email = $value;
                }

                $customerData = [
                    'name' => $name,
                    'email' => $email,
                    'address' => $address,
                    'phone' => $phone,
                    'facebook' => $facebook
                ];
                $customer = new Customer($customerData);
                $customer->save();
                
                echo "--Save customer: $email - id : $customer->id \n";
                $row++;
            }
            fclose($handle);
        }
    }
}