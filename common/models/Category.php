<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Product;
use common\models\ProductCategory;

/**
 * Category model
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $parent
 * @property integer $visible
 */
class Category extends ActiveRecord
{
    const INVISIBLE = 0;
    const VISIBLE = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    public function getPosts()
    {
    	return $this->hasMany(Product::className(), ['id' => 'post_id'])
            ->viaTable(ProductCategory::tableName(), ['category_id' => 'id']);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function getVisible()
    {
        return (int)$this->visible;
    }

    public function isVisible()
    {
        return $this->getVisible() === self::VISIBLE;
    }
}
