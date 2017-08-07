<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ward".
 *
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property string $location
 * @property integer $district_id
 */
class Ward extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ward';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'type', 'location', 'district_id'], 'required'],
            [['id', 'district_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['type', 'location'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'location' => 'Location',
            'district_id' => 'District ID',
        ];
    }
}
