<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\models\Post;
use common\models\PostWarning;
use common\forms\DisapprovePostForm;

/**
 * ContactForm is the model behind the contact form.
 */
class WarningPostForm extends Model
{
    public $id;
    public $message;

    private $_post;

     /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'message'], 'required'],
            ['id', 'validatePost']
        ];
    }

    public function report()
    {
        if ($this->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                // Disapprove the post
                $disapproveForm = new DisapprovePostForm(['id' => $this->id]);
                if (!$disapproveForm->disapprove()) {
                    throw new \Exception("Cannot disapprove", 1);
                }

                // Add message
                $warning = new PostWarning();
                $warning->post_id = $this->id;
                $warning->content = $this->message;
                $warning->created_at = strtotime('now');
                $warning->created_by = Yii::$app->user->id;
                $warning->save();

                $transaction->commit();
                return true;
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
