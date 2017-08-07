<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\models\Post;
use common\models\PostImage;
use common\models\PostCategory;
use common\models\PostContact;

/**
 * ContactForm is the model behind the contact form.
 */
class InsertPostForm extends Model
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    public $id;
    public $title;
    public $content;
    public $location_id;
    public $category_id;
    public $avatar_id;
    public $image = [];
    public $contact_name;
    public $contact_phone;
    public $contact_email;
    public $contact_facebook;
    public $contact_zalo;

    private $_post;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'category_id', 'contact_name', 'contact_phone'], 'required', 'on' => self::SCENARIO_CREATE],
            [['id', 'title', 'content', 'category_id', 'contact_name', 'contact_phone'], 'required', 'on' => self::SCENARIO_UPDATE],
            ['id', 'validatePost', 'on' => self::SCENARIO_UPDATE],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['title', 'content', 'category_id', 'contact_name', 'contact_phone'];
        $scenarios[self::SCENARIO_UPDATE] = ['id', 'title', 'content', 'category_id', 'contact_name', 'contact_phone'];
        return $scenarios;
    }

    public function save()
    {
        if ($this->validate()) {
            try {
                $this->initPost();
                return $this->_post->save();
            } catch (Exception $e) {

            }
        }
    }

    protected function initPost()
    {
        if ($this->scenario == self::SCENARIO_UPDATE) {
            $post = $this->getPost();
            $post->updated_at = strtotime('now');
        } else {
            $post = new Post();
            $post->user_id = Yii::$app->user->id;
            $post->created_at = strtotime('now');
            $post->updated_at = strtotime('now');
        }
        $post->title = $this->title;
        $post->content = $this->content;
        $post->location_id = $this->location_id;
        $post->category_id = $this->category_id;
        $post->contact_name = $this->contact_name;
        $post->contact_phone = $this->contact_phone;
        $post->contact_email = $this->contact_email;
        $post->contact_facebook = $this->contact_facebook;
        $post->contact_zalo = $this->contact_zalo;
        $this->_post = $post;
    }

    public function validatePost($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $post = $this->getPost();
            if (!$post) {
                $this->addError($attribute, 'Invalid post.');
            } elseif ($post->getUserId() != Yii::$app->user->id) {
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
