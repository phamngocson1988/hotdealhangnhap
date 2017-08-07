<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\models\OrderItem;

/**
 * UpdateOrderItemForm is the model behind the contact form.
 */
class UpdateOrderItemForm extends Model
{
    const SCENARIO_STEP1 = 'step1';
    const SCENARIO_STEP2 = 'step2';
    const SCENARIO_STEP3 = 'step3';
    const SCENARIO_STEP4 = 'step4';
    const SCENARIO_STEP5 = 'step5';
    const SCENARIO_STEP6 = 'step6';
    const SCENARIO_STEP7 = 'step7';

    public $id;
    public $link;
    public $description;
    public $price;
    public $weight;
    public $weight_fee;
    public $total_price;
    public $tracking;
    public $deliverer = 1;
    public $cod;

    private $_item;

    public function rules()
    {
        return [
            ['id', 'required'],
            ['id', 'validateItem'],
            ['tracking', 'required', 'on' => self::SCENARIO_STEP3],
            [['deliverer', 'cod'], 'required', 'on' => self::SCENARIO_STEP3]
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_STEP1] = [];
        $scenarios[self::SCENARIO_STEP2] = [];
        $scenarios[self::SCENARIO_STEP3] = ['id', 'weight', 'order_number', 'tracking'];
        $scenarios[self::SCENARIO_STEP4] = [];
        $scenarios[self::SCENARIO_STEP5] = ['id', 'deliverer', 'cod'];
        $scenarios[self::SCENARIO_STEP6] = [];
        $scenarios[self::SCENARIO_STEP7] = [];
        return $scenarios;
    }

    public function update()
    {
        $func = $this->scenario;
        return $this->$func();
    }

    public function step3()
    {
        $item = $this->getOrderItem();
        $item->weight = $this->weight;
        $item->tracking = $this->tracking;
        $this->_item = $item;
        return $item->save();
    }

    public function step5()
    {
        $item = $this->getOrderItem();
        $item->deliverer = $this->deliverer;
        $item->cod = $this->cod;
        $this->_item = $item;
        return $item->save();
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

    public function supportDeliverer()
    {
        return OrderItem::supportDeliverer();
    }

    public function loadData($id)
    {
        $this->id = $id;
        $item = $this->getOrderItem();
        $this->link = $item->link;
        $this->description = $item->description;
        $this->price = $item->price;
        $this->weight = $item->weight;
        $this->weight_fee = $item->weight_fee;
        $this->tracking = $item->tracking;
        $this->deliverer = $item->deliverer;
        $this->cod = $item->cod;
        $this->scenario = 'step' . $item->progress;
    }
}
