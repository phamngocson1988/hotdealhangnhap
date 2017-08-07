<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\models\Customer;

/**
 * UpdateCustomerForm is the model behind the contact form.
 */
class UpdateCustomerForm extends Model
{
    public $id;
    public $name;
    public $email;
    public $address;
    public $phone;
    public $facebook;
    public $code;
    public $note;

    private $_customer;

     /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'name'], 'required'],
            ['email', 'validateEmail']
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DEFAULT] = ['id', 'name', 'email', 'address', 'phone', 'facebook', 'note'];
        return $scenarios;
    }

    public function save()
    {
        if ($this->validate()) {
            $customer = $this->getCustomer();
            $customer->name = $this->name;
            $customer->email = $this->email;
            $customer->address = $this->address;
            $customer->phone = $this->phone;
            $customer->facebook = $this->facebook;
            // $customer->code = md5($this->email);
            $customer->note = $this->note;
            $customer->save();
            return $customer->id;
        }
        return false;
    }

    public function validateEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $customer = Customer::findOne(['email' => $this->email]);
            if ($customer->id != $this->id) {
                $this->addError($attribute, 'Email is exist');
            }
        }
    }

    public function getCustomer()
    {
        if (!$this->_customer) {
            $customer = Customer::findOne($this->id);
            $this->_customer = $customer;
        }
        return $this->_customer;
    }

    public function loadData($id)
    {
        $this->id = $id;
        $customer = $this->getCustomer();
        $this->name = $customer->name;
        $this->email = $customer->email;
        $this->address = $customer->address;
        $this->phone = $customer->phone;
        $this->facebook = $customer->facebook;
        $this->code = $customer->code;
        $this->note = $customer->note;
    }
}
