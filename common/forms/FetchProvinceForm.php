<?php
namespace common\forms;

use yii\base\Model;
use common\models\Province;
use Yii;

class FetchProvinceForm extends Model
{
    public $offset;
    public $limit;

    protected $_list;

    protected $_total;
    
    public function fetch()
    {
        $command = $this->createCommand();
        $command->offset($this->offset);
        $command->limit($this->limit);
        $this->_list = $command->all();
        return $this->getList();
    }

    public function count()
    {
        $command = $this->createCommand();
        $this->_total = $command->count();
        return $this->getTotal();
    }

    protected function createCommand()
    {
        $command = Province::find();
        return $command;
    }

    public function getList()
    {
        return $this->_list;
    }

    public function getTotal()
    {
        return $this->_total;
    }
}