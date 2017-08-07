<?php

namespace common\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "post_warning".
 *
 * @property integer $id
 * @property integer $post_id
 * @property string $content
 * @property integer $created_at
 * @property integer $created_by
 */
class PostWarning extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_warning';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'content', 'created_at', 'created_by'], 'required'],
            [['post_id', 'created_at', 'created_by'], 'integer'],
            [['content'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'content' => 'Content',
            'created_at' => 'Created At',
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getCreatedBy()
    {
        return $this->created_by;
    }

    public function getCreatedUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getContent()
    {
        return $this->content;
    }
}

