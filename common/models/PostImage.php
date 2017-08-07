<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * PostImage model
 *
 * @property integer $post_id
 * @property integer $image_id
 * @property integer $is_main
 */
class PostImage extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_image}}';
    }
}
