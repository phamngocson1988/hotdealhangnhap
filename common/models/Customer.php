<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $email
 * @property string $address
 * @property string $phone
 * @property string $facebook
 * @property string $note
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }
}
