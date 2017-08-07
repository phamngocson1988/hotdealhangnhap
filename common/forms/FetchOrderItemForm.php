<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\models\OrderItem;
use common\models\Order;
use common\models\Customer;

/**
 * FetchOrderItemForm is the model behind the contact form.
 */
class FetchOrderItemForm extends Model
{
    public $tracking;
    public $progress;
    public $email;
    public $month;
    public $hide_complete_item = true;


    public $offset;
    public $limit;

    private $_command;
    private $_list;
    private $_total;
    // private $_

    public function fetch()
    {
        $command = $this->createCommand();
        $itemTable = OrderItem::tableName();

        if ($this->tracking) {
            $command->andWhere("$itemTable.tracking = '" . $this->tracking . "'");
        }

        if ($this->progress) {
            $command->andWhere("$itemTable.progress = " . $this->progress);
        }

        if ($this->hide_complete_item && $this->progress != OrderItem::PROGRESS_COMPLETE) {
            $command->andWhere("$itemTable.progress <> " . OrderItem::PROGRESS_COMPLETE);
        }

        $orderTable = Order::tableName();
        $customerTable = Customer::tableName();
        $command->innerJoinWith($customerTable, "$customerTable.id = $orderTable.customer_id");
        if ($this->month) {
            $month = $this->month;
            $year = date('Y');
            $from = strtotime("$year-$month-01");
            $to = strtotime(date("$year-$month-t"));
            $command->andWhere("$orderTable.order_date >= " . $from);
            $command->andWhere("$orderTable.order_date <= " . $to);
        }

        if ($this->email) {
            $email = $this->email;
            $command->andWhere("$customerTable.email = '$email'");
        }

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
        $itemTable = OrderItem::tableName();
        $command = OrderItem::find();
        $command->limit($this->getLimit());
        $command->offset($this->getOffset());
        $command->orderBy("$itemTable.id desc");
        return $command;
    }

    public function getMonths()
    {
        return [
            '1' => 'Tháng 1',
            '2' => 'Tháng 2',
            '3' => 'Tháng 3',
            '4' => 'Tháng 4',
            '5' => 'Tháng 5',
            '6' => 'Tháng 6',
            '7' => 'Tháng 7',
            '8' => 'Tháng 8',
            '9' => 'Tháng 9',
            '10' => 'Tháng 10',
            '11' => 'Tháng 11',
            '12' => 'Tháng 12'
        ];
    }

    public function getSupportedProgress()
    {
        return OrderItem::supportProgress();
    }
}
