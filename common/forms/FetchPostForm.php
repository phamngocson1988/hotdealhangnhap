<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\models\Post;

/**
 * ContactForm is the model behind the contact form.
 */
class FetchPostForm extends Model
{
    public $q;
    public $status;
    public $category_id;
    public $user_id;
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

    public function search()
    {
        $command = $this->createCommand();
        $postTable = Post::tableName();

        if ($this->getQuery()) {
            $query->andWhere([
                'or',
                ['like', "$postTable.title", $this->getQuery()],
                ['like', "$postTable.content", $this->getQuery()],
            ]);
        }

        if ($this->category_id !== null) {
            $postCategoryTable = PostCategory::tableName();
            $command->select(["$postTable.*"]);
            $command->innerJoin($postCategoryTable, "$postCategoryTable.category_id = " . $this->getCategoryId());
        }

        if ($this->getStatus() !== null) {
            $command->andWhere("$postTable.status = " . $this->getStatus());
        }

        // if ($this->getBudgetForm()) {
        //     $command->andWhere("$postTable.budget_to >= " . $this->getBudgetForm());
        // }

        // if ($this->getBudgetTo()) {
        //     $command->andWhere("$postTable.budget_from <= " . $this->getBudgetTo());
        // }

        $this->_list = $command->all();
        $this->_command = $command;
        return $this->getList();
    }

    public function fetchByCategory()
    {
        $command = $this->createCommand();
        $postTable = Post::tableName();
        $postCategoryTable = PostCategory::tableName();
        $command->select(["$postTable.*"]);
        $command->innerJoin($postCategoryTable, "$postCategoryTable.category_id = " . $this->getCategory());
        $this->_list = $command->all();
        $this->_command = $command;
        return $this->getList();
    }

    public function fetchByUser()
    {
        $command = $this->createCommand();
        $postTable = Post::tableName();
        $command->andWhere("$postTable.user_id = " . $this->getUserId());
        if ($this->getStatus() !== null) {
            $command->andWhere("$postTable.status = " . $this->getStatus());
        }
        $this->_list = $command->all();
        $this->_command = $command;
        return $this->getList();
    }

    public function fetchUnchecked()
    {
        $command = $this->createCommand();
        $postTable = Post::tableName();
        $command->andWhere("$postTable.checked_by IS NULL");
        $this->_list = $command->all();
        $this->_command = $command;
        return $this->getList();
    }

    public function fetchInvalid()
    {
        $command = $this->createCommand();
        $postTable = Post::tableName();
        $command->andWhere("$postTable.checked_by IS NOT NULL");
        $command->andWhere("$postTable.status = " . Post::STATUS_INVISIBLE);
        $this->_list = $command->all();
        $this->_command = $command;
        return $this->getList();
    }

    public function count()
    {
        $this->_total = $this->_command->count();
        return $this->getTotal();
    }

    // public function getBudgetForm()
    // {
    //     return $this->budget_from;
    // }

    // public function getBudgetTo()
    // {
    //     return $this->budget_to;
    // }

    public function getCategoryId()
    {
        return $this->category_id;
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

    public function getStatus()
    {
        return $this->status;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    // public function getOrganization()
    // {
    //     return $this->organization;
    // }

    public function getQuery()
    {
        return $this->q;
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
        $command = Post::find();
        $command->limit($this->getLimit());
        $command->offset($this->getOffset());
        $order = sprintf("%s %s", $this->getOrderField(), $this->getOrder());
        $command->orderBy('id desc');
        $command->with('user');
        $command->with('category');
        $command->with('checkedByUser');
        return $command;
    }
}
