<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\models\Customer;

/**
 * FetchCustomerForm is the model behind the contact form.
 */
class FetchCustomerForm extends Model
{
    public $offset;
    public $limit;
    private $_command;
    private $_list;
    private $_total;

    public function fetch()
    {
        $command = $this->createCommand();
        $this->_list = $command->all();
        $this->_command = $command;
        return $this->getList();
    }

    public function count()
    {
        $this->_total = $this->_command->count();
        return $this->getTotal();
    }

    public function getOffset()
    {
        return (int)$this->offset;
    }

    public function getLimit()
    {
        return (int)$this->limit;
    }

    public function getList()
    {
        return $this->_list;
    }

    public function getTotal()
    {
        return $this->_total;
    }

    protected function createCommand()
    {
        $command = Customer::find();
        $command->limit($this->getLimit());
        $command->offset($this->getOffset());
        $command->orderBy('id desc');
        return $command;
    }
}
