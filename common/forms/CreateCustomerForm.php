<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\models\Customer;

/**
 * CreateCustomerForm is the model behind the contact form.
 */
class CreateCustomerForm extends Model
{
    public $name;
    public $email;
    public $address;
    public $phone;
    public $facebook;
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
        $scenarios[self::SCENARIO_DEFAULT] = ['name', 'email', 'address', 'phone', 'facebook', 'note'];
        return $scenarios;
    }

    public function save()
    {
        if ($this->validate()) {
            $customer = new Customer();
            $customer->name = $this->name;
            $customer->email = $this->email;
            $customer->address = $this->address;
            $customer->phone = $this->phone;
            $customer->facebook = $this->facebook;
            $customer->code = md5($this->email);
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
            if ($customer) {
                $this->addError($attribute, 'Customer is exist');
            }
        }
    }
}
