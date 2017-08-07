<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\models\Post;
use common\models\PostWarning;

/**
 * ContactForm is the model behind the contact form.
 */
class ApprovePostForm extends Model
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

    public function approve()
    {
        if ($this->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $post = $this->getPost();
                // Update status
                $post->status = Post::STATUS_VISIBLE;
                // Update the people who approved this post
                $post->checked_by = Yii::$app->user->id;

                $post->save();

                // Remove all warnings
                PostWarning::deleteAll(['post_id' => $this->id]);

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
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
