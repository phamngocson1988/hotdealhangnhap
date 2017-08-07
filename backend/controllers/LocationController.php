<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\forms\FetchLocationForm;
use common\forms\ChangeVisibleLocationForm;
use yii\data\Pagination;
use yii\web\Response;

/**
 * LocationController
 */
class LocationController extends Controller
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

    public function actionIndex()
    {
        $request = Yii::$app->request;

        $form = new FetchLocationForm();
        $models = $form->fetch();
        return $this->render('index.tpl', [
            'models' => $models,
        ]);
    }

    public function actionChangeVisible($id)
    {
        $request = Yii::$app->request;
        if (!$request->isAjax) {
            return;
        }
        
        $visible = $request->get('visible', 1);
        $model = new ChangeVisibleLocationForm(['id' => $id, 'visible' => $visible]);
        if ($model->change()) {
            $result['status'] = true;
        } else {
            $result['status'] = false;
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }
}
