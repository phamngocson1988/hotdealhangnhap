<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\forms\FetchCategoryForm;
use common\forms\UpdateCategoryForm;
use common\models\Category;
use common\forms\ChangeVisibleCategoryForm;
use yii\web\Response;

/**
 * CategoryController
 */
class CategoryController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Show the list of posts
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $form = new FetchCategoryForm();
        $models = $form->fetch();
        return $this->render('index.tpl', [
            'models' => $models,
        ]);
    }

    public function actionEdit($id)
    {
        $model = new UpdateCategoryForm(['id' => $id, 'scenario' => UpdateCategoryForm::SCENARIO_EDIT]);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $this->redirect(['category/index']);
            }
        } else {
            $category = Category::findOne($id);
            $model->name = $category->getName();
            $model->slug = $category->getSlug();
        }
        return $this->render('create.tpl', [
            'model' => $model,
        ]);

    }

    public function actionCreate()
    {
        $model = new UpdateCategoryForm(['scenario' => UpdateCategoryForm::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $this->redirect(['category/index']);
            }
        }

        return $this->render('create.tpl', [
            'model' => $model,
        ]);
    }

    public function actionChangeVisible($id)
    {
        $request = Yii::$app->request;
        if (!$request->isAjax) {
            return;
        }
        
        $visible = $request->get('visible', 1);
        $model = new ChangeVisibleCategoryForm(['id' => $id, 'visible' => $visible]);
        if ($model->change()) {
            $result['status'] = true;
        } else {
            $result['status'] = false;
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }
}
