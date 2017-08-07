<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\models\Post;

/**
 * ReadPostForm is the model behind the contact form.
 */
class ReadPostForm extends Model
{
    public $id;

    public function rules()
    {
        return [
            ['id', 'required'],
        ];
    }

    public function read()
    {
        if ($this->validate()) {
            $command = Post::find()->where(['id' => $this->id]);
            $command->with('images');
            $command->with('user');
            $command->with('category');
            $command->with('checkedByUser');
            return $command->one();
        }
        return false;
    }
}
