<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_item".
 *
 * @property integer $id
 * @property integer $order_id
 * @property string $name
 * @property string $link
 * @property string $description
 * @proprety integer $price
 * @property integer $weight
 * @property integer $weight_fee
 * @property integer $total_price
 * @property string $tracking
 * @property integer $deliverer
 * @property integer $cod
 * @property integer $progress
 */
class OrderItem extends \yii\db\ActiveRecord
{
    const PROGRESS_UNORDER = 1;
    const PROGRESS_ORDERED = 2;
    const PROGRESS_US_STOCK = 3;
    const PROGRESS_TRANSFER = 4;
    const PROGRESS_VN_STOCK = 5;
    const PROGRESS_SHIPPED = 6;
    const PROGRESS_COMPLETE = 7;

    const DELIVERER_NONE = 0;
    const DELIVERER_VIETTELPOST = 1;
    const DELIVERER_GIAOHANGTIETKIEM = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_item';
    }

    public static function supportProgress()
    {
        return [
            self::PROGRESS_UNORDER => 'Unorder',
            self::PROGRESS_ORDERED => 'Ordered',
            self::PROGRESS_US_STOCK => 'US Stock',
            self::PROGRESS_TRANSFER => 'Transfer',
            self::PROGRESS_VN_STOCK => 'VN Stock',
            self::PROGRESS_SHIPPED => 'Shipped',
            self::PROGRESS_COMPLETE => 'Complete',
        ];
    }

    public static function supportDeliverer()
    {
        return [
            self::DELIVERER_NONE => 'Nhận hàng tại kho',
            self::DELIVERER_VIETTELPOST => 'Viettel Post',
            self::DELIVERER_GIAOHANGTIETKIEM => 'Giao hàng tiết kiệm',
        ];
    }

    public function getProgressName()
    {
        $progress = $this->progress;
        $list = self::supportProgress();
        if (array_key_exists($progress, $list)) {
            return $list[$progress];
        }
        return false;
    }

    public function getNextProgress()
    {
        $progress = $this->progress;
        $progress++;
        $list = self::supportProgress();
        if (array_key_exists($progress, $list)) {
            return $progress;
        }
        return false;
    }

    public function getPrevProgress()
    {
        $progress = $this->progress;
        $progress--;
        $list = self::supportProgress();
        if (array_key_exists($progress, $list)) {
            return $progress;
        }
        return false;
    }

    public function getNextProgressName()
    {
        $progress = $this->getNextProgress();
        if (!$progress) {
            return false;
        }
        $list = self::supportProgress();
        return $list[$progress];
    }

    public function isComplete()
    {
        return $this->progress === self::PROGRESS_COMPLETE;
    }

    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id'])
            ->viaTable(Order::tableName(), ['id' => 'order_id']);
    }

    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}
