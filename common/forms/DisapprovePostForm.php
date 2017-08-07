<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\models\Post;

/**
 * ContactForm is the model behind the contact form.
 */
class DisapprovePostForm extends Model
{
    public $id;

    private $_post;

     /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'required'],
            ['id', 'validatePost']
        ];
    }

    public function disapprove()
    {
        if ($this->validate()) {
            $post = $this->getPost();
            // Update status
            $post->status = Post::STATUS_INVISIBLE;
            // Update the people who approved this post
            $post->checked_by = Yii::$app->user->id;

            return $post->save();

        }
        return false;
    }

    public function validatePost($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $post = $this->getPost();
            if (!$post) {
                $this->addError($attribute, 'Invalid post.');
            }
        }
    }

    protected function getPost()
    {
        if ($this->_post === null) {
            $this->_post = Post::findOne($this->id);
        }

        return $this->_post;
    }
}
