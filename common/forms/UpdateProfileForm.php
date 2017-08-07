<?php
namespace common\forms;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * UpdateProfileForm form
 */
class UpdateProfileForm extends Model
{
    public $name;
    public $phone;
    public $address;
    public $gender;
    public $year_of_birth;

    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'string', 'min' => 3, 'max' => 255],

            ['phone', 'trim'],
            ['phone', 'required'],

            [['address', 'gender', 'year_of_birth'], 'trim'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function save()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = $this->getUser();
        $user->name = $this->name;
        $user->phone = $this->phone;
        $user->gender = $this->gender;
        $user->address = $this->address;
        $user->year_of_birth = $this->year_of_birth;
        // dd($this);
        return $user->save() ? $user : null;
    }

    protected function getUser()
    {
        return Yii::$app->user->getIdentity();
    }
}
