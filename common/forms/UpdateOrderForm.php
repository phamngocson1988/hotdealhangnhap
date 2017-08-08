<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\models\Order;
use common\models\OrderItem;
use common\models\Customer;

/**
 * UpdateOrderForm is the model behind the contact form.
 */
class UpdateOrderForm extends Model
{
    public $id;
    public $description;
    public $prepay;

    // Information for order items
    public $item_id = [];
    public $item_link = [];
    public $item_description = [];
    public $item_weight = [];
    public $item_price = [];

    private $_order;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'required'],
            [['description', 'prepay', 'item_description'], 'trim'],
            ['item_id', 'each', 'rule' => ['required']],
            ['item_link', 'each', 'rule' => ['required']],
            [['prepay', 'item_price'], 'filter', 'filter' => function ($value) {
                return str_replace(',', '', $value);
            }],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DEFAULT] = ['id', 'description', 'prepay', 'item_id', 'item_link', 'item_description', 'item_weight', 'item_price'];
        return $scenarios;
    }

    public function save()
    {
        if ($this->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $order = $this->getOrder();
                $order->description = $this->description;
                $order->prepay = (int)$this->prepay;
                $order->save();

                $orderId = $order->id;

                // Save order items
                $items = $this->getItemInformation();
                foreach ($items as $itemId => $item) {
                    $orderItem = OrderItem::findOne($itemId);
                    $orderItem->link = $item['link'];
                    $orderItem->description = $item['description'];
                    $orderItem->weight = $item['weight'];
                    $orderItem->price = $item['price'];
                    $orderItem->save();
                }
                $transaction->commit();
                return $orderId;
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
    }

    protected function getItemInformation()
    {
        $ids = $this->getItemId();
        $links = $this->getItemLink();
        $descriptions = $this->getItemDescription();
        $weights = $this->getItemWeight();
        $prices = $this->getItemPrices();
        $items = [];
        foreach ($ids as $key => $id) {
            $item = [
                'id' => $id,
                'link' => $links[$key],
                'description' => $descriptions[$key],
                'weight' => $weights[$key],
                'price' => $prices[$key],
            ];
            $items[$id] = $item;
        }
        return $items;
    }

    protected function getItemId()
    {
        return (array)$this->item_id;
    }

    protected function getItemLink()
    {
        return (array)$this->item_link;
    }

    protected function getItemPrices()
    {
        return (array)$this->item_price;
    }

    protected function getItemDescription()
    {
        return (array)$this->item_description;
    }

    protected function getItemWeight()
    {
        return (array)$this->item_weight;
    }

    public function loadData($id)
    {
        $order = Order::findOne($id);
        $this->id = $id;
        $this->description = $order->description;
        $this->prepay = $order->prepay;

        // foreach ($order->items as $item) {
        //     $this->item_link[] = $item->link;
        //     $this->item_description[] = $item->description;
        //     $this->item_price[] = $item->price;
        //     $this->item_weight[] = $item->weight;
        // }
        $this->_order = $order;
    }

    public function getOrder()
    {
        if ($this->_order === null) {
            $this->_order = Order::findOne($this->id);
        }

        return $this->_order;
    }

    public function getCustomer()
    {
        $order = $this->getOrder();
        return $order->customer;
    }

    public function getItems()
    {
        $order = $this->getOrder();
        return $order->items;
    }
}
