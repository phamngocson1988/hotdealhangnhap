<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\models\Order;
use common\models\OrderItem;
use common\models\Customer;
use common\forms\CreateCustomerForm;

/**
 * InsertOrderForm is the model behind the contact form.
 */
class InsertOrderForm extends Model
{
    public $description;
    public $prepay;

    // Information for order items
    public $item_link = [];
    public $item_description = [];
    public $item_weight = [];
    public $item_price = [];

    public $customer_name;
    public $customer_email;
    public $customer_address;
    public $customer_phone;
    public $customer_facebook;
    private $_customer;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'prepay', 'item_description'], 'trim'],
            [['customer_email'], 'required'],
            ['item_link', 'each', 'rule' => ['required']],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DEFAULT] = ['customer_email', 'customer_name', 'customer_address', 'customer_phone', 'customer_facebook', 'item_link', 'description', 'prepay', 'item_description', 'item_weight', 'item_price'];
        return $scenarios;
    }

    public function save()
    {
        if ($this->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                // Check customer
                $customer = $this->getCustomer();
                if (!$customer) {
                    $this->createCustomer();
                    $customer = $this->getCustomer();
                }
                $order = new Order();
                $order->code = md5(strtotime('now'));
                $order->customer_id = $customer->id;
                $order->order_date = strtotime('now');
                $order->description = $this->description;
                $order->prepay = (int)$this->prepay;
                $order_created_by = Yii::$app->user->id;
                $order->save();

                $orderId = $order->id;

                // Save order items
                $items = $this->getItemInformation();
                foreach ($items as $item) {
                    $orderItem = new OrderItem($item);
                    $orderItem->order_id = $orderId;
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
        $links = $this->getItemLink();
        
        $descriptions = $this->getItemDescription();
        $weights = $this->getItemWeight();
        $prices = $this->getItemPrices();
        $items = [];
        foreach ($links as $key => $link) {
            $link = trim($link);
            if (!$link) {
                continue;
            }
            $item = [
                'link' => $link,
                'description' => $descriptions[$key],
                'weight' => $weights[$key],
                'price' => $prices[$key],
            ];
            $items[] = $item;
        }
        return $items;
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

    protected function getCustomer()
    {
        if (!$this->_customer) {
            $this->_customer = Customer::findOne(['email' => $this->customer_email]);
        }
        return $this->_customer;
    }

    protected function createCustomer()
    {
        $customerData = [
            'name' => $this->customer_name,
            'email' => $this->customer_email,
            'address' => $this->customer_address,
            'phone' => $this->customer_phone,
            'facebook' => $this->customer_facebook
        ];
        $createCustomerForm = new CreateCustomerForm($customerData);
        return $createCustomerForm->save();
    }
}
