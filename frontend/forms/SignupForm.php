<?php
namespace frontend\forms;

use common\models\User;
use common\forms\SignupForm as BaseSignupForm;

/**
 * Signup form
 */
class SignupForm extends BaseSignupForm
{
    protected function setExtraAttributes(&$user) 
    {
        $user->is_staff = User::ROLE_MEMBER;
    }
}
