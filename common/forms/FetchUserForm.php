<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * FetchUserForm is the model behind the contact form.
 */
class FetchUserForm extends Model
{
    public $is_staff;
    public $offset = 0;
    public $limit = 10;
    public $order_field = 'id';
    public $order = 'DESC';

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

    public function fetchMember()
    {
        $command = $this->createCommand();
        $command->andWhere("is_staff = 0");
        $this->_list = $command->all();
        $this->_command = $command;
        return $this->getList();
    }

    public function fetchStaff()
    {
        $command = $this->createCommand();
        $command->andWhere("is_staff = 1");
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

    public function getOrder()
    {
        if (in_array(strtoupper($this->order), ['DESC', 'ASC'])) {
            return $this->order;
        }
        return 'DESC';
    }

    public function getOrderField()
    {
        return $this->order_field;
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
        $command = User::find();
        $command->limit($this->getLimit());
        $command->offset($this->getOffset());
        $order = sprintf("%s %s", $this->getOrderField(), $this->getOrder());
        $command->orderBy($order);
        $command->with('avatarImage');
        return $command;
    }
}
