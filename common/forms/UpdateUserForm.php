<?php
namespace common\forms;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\helpers\ArrayHelper;

class UpdateUserForm extends Model
{
	public $id;
	public $name;
	public $phone;
	public $address;
	public $year_of_birth;
	public $sex;
	public $avatar;

	private $_user;

	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	['name', 'trim'],
            [['id', 'name', 'phone', 'address'], 'required'],
            ['id', 'validateUser']
        ];
    }

    public function update()
    {
    	if ($this->validate()) {
    		$user = $this->getUser();
    		$user->name = $this->name;
    		$user->phone = $this->phone;
    		$user->address = $this->address;
    		$user->year_of_birth = $this->year_of_birth;
    		$user->sex = $this->sex;
    		$user->avatar = $this->avatar;
    		return $user->save();
        } else {
            return false;
        }
    }

    public function validateUser($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user) {
                $this->addError($attribute, 'Invalid user.');
            } elseif ($user->getId() != Yii::$app->user->id) {
            	$this->addError($attribute, 'Invalid user.');
            }
        }
    }

    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findIdentity($this->id);
        }

        return $this->_user;
    }
}
?>