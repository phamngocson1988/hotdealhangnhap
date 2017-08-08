<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\models\OrderItem;
use common\models\Order;

/**
 * UpdateOrderItemForm is the model behind the contact form.
 */
class UpdateOrderItemForm extends Model
{
    // const SCENARIO_STEP0 = 'step0';
    // const SCENARIO_STEP1 = 'step1';
    // const SCENARIO_STEP2 = 'step2';
    // const SCENARIO_STEP3 = 'step3';
    // const SCENARIO_STEP4 = 'step4';
    // const SCENARIO_STEP5 = 'step5';
    // const SCENARIO_STEP6 = 'step6';
    // const SCENARIO_STEP7 = 'step7';

    const SCENARIO_ADMIN = 'admin';
    const SCENARIO_USKEEPER = 'us_keeper';
    const SCENARIO_VNKEEPER = 'vn_keeper';

    public $id;
    public $link;
    public $description;
    public $price;
    public $weight;
    public $weight_fee;
    public $total_price;
    public $tracking;
    public $order_number;
    public $order_stock;
    public $deliverer = 1;
    public $cod;
    public $note;

    private $_item;

    public function rules()
    {
        return [
            ['id', 'required'],
            ['id', 'validateItem'],
            [['weight', 'cod'], 'filter', 'filter' => function ($value) {
                return str_replace(',', '', $value);
            }],
            // ['tracking', 'required', 'on' => self::SCENARIO_STEP3],
            // [['deliverer', 'cod'], 'required', 'on' => self::SCENARIO_STEP3]
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        // $scenarios[self::SCENARIO_STEP0] = [];
        // $scenarios[self::SCENARIO_STEP1] = ['order_number'];
        // $scenarios[self::SCENARIO_STEP2] = ['tracking'];
        // $scenarios[self::SCENARIO_STEP3] = ['id', 'weight'];
        // $scenarios[self::SCENARIO_STEP4] = [];
        // $scenarios[self::SCENARIO_STEP5] = ['id', 'deliverer', 'cod'];
        // $scenarios[self::SCENARIO_STEP6] = [];
        // $scenarios[self::SCENARIO_STEP7] = [];

        $scenarios[self::SCENARIO_DEFAULT] = ['id', 'order_number', 'order_stock', 'weight', 'tracking', 'deliverer', 'cod', 'note'];
        // $scenarios[self::SCENARIO_ADMIN] = ['id', 'order_number', 'weight', 'tracking', 'deliverer', 'cod'];
        // $scenarios[self::SCENARIO_USKEEPER] = ['id', 'weight', 'tracking'];
        // $scenarios[self::SCENARIO_USKEEPER] = ['id', 'deliverer', 'cod'];
        return $scenarios;
    }

    public function update()
    {
        // $func = $this->scenario;
        // return $this->$func();
        if ($this->validate()) {
            $user = Yii::$app->user;
            $item = $this->getOrderItem();
            if ($user->can('us_keeper')) {
                $item->weight = $this->getWeight();
                $item->tracking = $this->tracking;
            }
            if ($user->can('vn_keeper')) {
                $item->deliverer = $this->deliverer;
                $item->cod = $this->cod;
                $item->note = $this->note;
            }

            if ($user->can('admin')) {
                $order = $this->getOrder();
                $order->order_number = $this->order_number;
                $order->stock = $this->order_stock;
                $order->save();
            }
            return $item->save();
        }
        return false;
    }

    // public function step3()
    // {
    //     $item = $this->getOrderItem();
    //     $item->weight = $this->weight;
    //     $item->tracking = $this->tracking;
    //     $this->_item = $item;
    //     return $item->save();
    // }

    // public function step5()
    // {
    //     $item = $this->getOrderItem();
    //     $item->deliverer = $this->deliverer;
    //     $item->cod = $this->cod;
    //     $this->_item = $item;
    //     return $item->save();
    // }

    public function getOrderItem()
    {
        if ($this->_item === null) {
            $this->_item = OrderItem::findOne($this->id);
        }

        return $this->_item;
    }

    public function getOrder()
    {
        $item = $this->getOrderItem();
        return $item->order;
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

    public function supportStock()
    {
        return Order::supportStock();
    }

    public function getWeight()
    {
        return (int)$this->weight;
    }

    public function getWeightFee()
    {
        return (int)$this->weight_fee;
    }

    public function loadData($id)
    {
        $this->id = $id;
        $item = $this->getOrderItem();
        $order = $this->getOrder();
        $this->link = $item->link;
        $this->description = $item->description;
        $this->price = $item->price;
        $this->weight = $item->getWeight();
        $this->weight_fee = $item->getWeightFee();
        $this->tracking = $item->tracking;
        $this->deliverer = $item->deliverer;
        $this->cod = $item->cod;
        $this->order_number = $order->order_number;
        $this->order_stock = $order->stock;
        // $this->scenario = 'step' . $item->progress;
    }
}
