<?php

namespace common\models;

use Yii;
use common\models\User;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $code
 * @property string $order_number
 * @property integer $customer_id
 * @property integer $order_date
 * @property string $description
 * @property integer $prepay
 * @property integer $stock
 * @property integer $created_by
 */
class Order extends \yii\db\ActiveRecord
{//US Ngân, US HNC, US chuyenhangus, UK, JP
    const STOCK_USNGAN = 1;
    const STOCK_USHNC = 2;
    const STOCK_USCHUYENHANGUS = 3;
    const STOCK_UK = 4;
    const STOCK_JP = 5;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    public static function supportStock()
    {
        return [
            self::STOCK_USNGAN => 'US Ngân',
            self::STOCK_USHNC => 'US HNC',
            self::STOCK_USCHUYENHANGUS => 'US chuyenhangus',
            self::STOCK_UK => 'UK',
            self::STOCK_JP => 'JP',
        ];
    }

    public function getItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_id' => 'id']);
    }

    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    public function getCreatedUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getStockName()
    {
        $stocks = self::supportStock();
        return ArrayHelper::getValue($stocks, $this->stock, '');
    }
}
