<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\models\PostWarning;

/**
 * ContactForm is the model behind the contact form.
 */
class DeleteWarningPostForm extends Model
{
    public $id;

    public function delete()
    {
        return PostWarning::deleteAll(['id' => $this->id]);
    }
}
