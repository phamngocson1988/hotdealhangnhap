<?php

namespace common\forms;

use Yii;
use yii\base\Model;
use common\models\Category;
use common\components\helpers\StringHelper;

/**
 * UpdateCategoryForm is the model behind the contact form.
 */
class UpdateCategoryForm extends Model
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_EDIT = 'edit';

    public $id;
    public $name;
    public $slug;

    private $_category;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required', 'on' => self::SCENARIO_CREATE],

            [['id', 'name', 'slug'], 'required', 'on' => self::SCENARIO_EDIT],
            ['id', 'validateCategory', 'on' => self::SCENARIO_EDIT],
            ['slug', 'validateSlug'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['name', 'slug'];
        $scenarios[self::SCENARIO_EDIT] = ['id', 'name', 'slug'];
        return $scenarios;
    }

    public function save()
    {
        if ($this->validate()) {
            try {
                if ($this->scenario == self::SCENARIO_EDIT) {
                    $category = $this->getCategory();
                } else {
                    $category = new Category();
                }
                $category->name = $this->name;
                $category->slug = $this->slug;
                return $category->save();
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }

    protected function getCategory()
    {
        if ($this->_category === null) {
            $this->_category = Category::findOne($this->id);
        }

        return $this->_category;
    }

    public function validateCategory($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $category = $this->getCategory();
            if (!$category) {
                $this->addError($attribute, 'Invalid category.');
            }
        }
    }

    public function validateSlug($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $slug = $this->$attribute;
            if (!preg_match('/^[a-z][-a-z0-9]*$/', $slug)) {
                $this->addError($attribute, "$slug does not match slug format!");
            }

            if (Category::find()->where(['slug' => $slug])->count() > 0) {
                $this->addError($attribute, "$slug already existed!");
            }
        }
    }
}
