<?php

namespace backend\forms;

use yii\base\Model;
use common\models\User;
use common\forms\SignupForm as BaseSignupForm;

/**
 * InsertStaffForm is the model behind the contact form.
 */
class SignupForm extends BaseSignupForm
{
    protected function setExtraAttributes(&$user) 
    {
        $user->name = $this->username;
        $user->is_staff = User::ROLE_STAFF;
    }
}
