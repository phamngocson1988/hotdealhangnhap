<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property string $key
 * @property string $value
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key'], 'required'],
            [['value'], 'string'],
            [['key'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'key' => 'Key',
            'value' => 'Value',
        ];
    }

    public static function get($key) 
    {
        $setting = static::findOne(['key' => $key]);
        if (!$setting) {
            return null;
        }

        $data = @unserialize($setting->value);
        if ($data !== false) {
            $setting->value = $data;
        }
        return $setting;
    }

    public static function set($key, $value)
    {
        $setting = static::findOne(['key' => $key]);
        if (!$setting) {
            $setting = new self();
            $setting->key = $key;
        }

        if (is_array($value) || is_object($value)) {
            $value = @serialize($value);
        }

        $setting->value = $value;
        return $setting->save();
    }

    public static function remove($key) 
    {
        return Setting::deleteAll(['key' => $key]);
    }
}
