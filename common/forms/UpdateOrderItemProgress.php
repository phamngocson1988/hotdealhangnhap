<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\models\OrderItem;

/**
 * UpdateOrderItemProgress is the model behind the contact form.
 */
class UpdateOrderItemProgress extends Model
{
    public $id;
    public $progress;

    private $_item;

    public function rules()
    {
        return [
            [['id', 'progress'], 'required'],
            ['id', 'validateItem']
        ];
    }

    public function update()
    {
        $item = $this->getOrderItem();
        $item->progress = $this->progress;
        $item->save();
        $this->_item = $item;
        return true;
    }

    public function getOrderItem()
    {
        if ($this->_item === null) {
            $this->_item = OrderItem::findOne($this->id);
        }

        return $this->_item;
    }

    public function validateItem($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $item = $this->getOrderItem();
            if (!$item) {
                $this->addError($attribute, 'item is not exist');
                return false;
            }
        }
    }
}
