<?php

namespace common\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $code
 * @property integer $customer_id
 * @property integer $order_date
 * @property string $description
 * @property integer $prepay
 * @property integer $created_by
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
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
}
