<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Image;
use common\models\Category;
use common\models\PostImage;
use common\models\User;
use common\models\PostWarning;

/**
 * Post model
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $type
 * @property integer $organization
 * @property integer $location_id
 * @property integer $category_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $user_id
 * @property integer $checked_by
 * @property integer $status
 * @property string $contact_name
 * @property string $contact_phone
 * @property string $contact_email
 * @property string $contact_facebook
 * @property string $contact_zalo
 */
class Post extends ActiveRecord
{
	const STATUS_INVISIBLE = 0;
    const STATUS_VISIBLE = 1;

    const ORGANIZATION_PERSON = 0;
    const ORGANIZATION_COMPANY = 1;

    const TYPE_DEALER = 0;
    const TYPE_COOPERATION = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    public static function getSupportedStatus()
    {
    	return [
    		self::STATUS_INVISIBLE,
    		self::STATUS_VISIBLE
    	];
    }

    public static function getSupportedOrganization()
    {
        return [
            self::ORGANIZATION_PERSON,
            self::ORGANIZATION_COMPANY
        ];   
    }

    public static function getSupportedType()
    {
        return [
            self::TYPE_DEALER,
            self::TYPE_COOPERATION
        ];
    }

    public function getImages()
    {
        return $this->hasMany(Image::className(), ['id' => 'image_id'])
            ->viaTable(PostImage::tableName(), ['post_id' => 'id']);
    }

    public function getCategoryId()
    {
        return $this->category_id;
    }

    public function getCategory() 
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getOrganization()
    {
        $organizations = self::getSupportedOrganization();
        if (in_array($this->organization, $organizations)) {
            return $this->organization;
        }
        return 0;
    }

    public function getCreatedAt($format = false)
    {
        if ($format == true) {
            return date("F j, Y, g:i a", $this->created_at);
        }
        return $this->created_at;
    }

    public function getUpdatedAt($format = false)
    {
        if ($format == true) {
            return date("F j, Y, g:i a", $this->updated_at);
        }
        return $this->updated_at;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getCheckedBy()
    {
        return $this->checked_by;
    }

    public function getCheckedByUser()
    {
        return $this->hasOne(User::className(), ['id' => 'checked_by']);
    }

    public function getStatus()
    {
        $status = self::getSupportedStatus();
        if (in_array($this->status, $status)) {
            return $this->status;
        }
        return 0;
    }

    public function getStatusLabel() 
    {
        if (!$this->getCheckedBy()) {
            $label = 'New';
        } elseif ($this->isVisible()) {
            $label = 'Approved';
        } else {
            $label = 'Warning';
        }
        return $label;
    }

    public function isVisible()
    {
        return $this->getStatus() === self::STATUS_VISIBLE;
    }

    public function getAvatarImage()
    {
        foreach ($this->images as $image) {
            if ($image->is_main) {
                return $image;
            }
        }
        return null;
    }

    public function getAvatarUrl($size, $default = '../../images/image-placeholder.png')
    {
        $image = $this->getAvatarImage();
        if ($image) {
            return $image->getUrl($size);
        }
        return $default;
    }

    public function getContactPhone()
    {
        return $this->contact_phone;
    }

    public function getContactName()
    {
        return $this->contact_name;
    }

    public function getWarnings()
    {
        $query = $this->hasMany(PostWarning::className(), ['post_id' => 'id']);
        $query->orderBy(['created_at'=>SORT_DESC]);
        // dd($query->getQuery());
        return $query;
    }
}
