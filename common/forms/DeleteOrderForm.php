<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\models\Order;
use common\models\OrderItem;

/**
 * DeleteOrderForm is the model behind the contact form.
 */
class DeleteOrderForm extends Model
{
    public $id;

    public function delete()
    {
    	OrderItem::deleteAll(['order_id' => $this->id]);
        return Order::deleteAll(['id' => $this->id]);
    }
}
