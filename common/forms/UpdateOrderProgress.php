<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\models\Order;

/**
 * UpdateOrderProgress is the model behind the contact form.
 */
class UpdateOrderProgress extends Model
{
    public $id;
    public $progress;

    private $_order;

    public function rules()
    {
        return [
            [['id', 'progress'], 'required'],
            ['id', 'validateOrder']
        ];
    }

    public function update()
    {
        $order = $this->getOrder();
        $order->progress = $this->progress;
        $order->save();
        $this->_order = $order;
        return true;
    }

    public function getOrder()
    {
        if ($this->_order === null) {
            $this->_order = Order::findOne($this->id);
        }

        return $this->_order;
    }

    public function validateOrder($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $order = $this->getOrder();
            if (!$order) {
                $this->addError($attribute, 'order is exist');
                return false;
            }
        }
    }
}
