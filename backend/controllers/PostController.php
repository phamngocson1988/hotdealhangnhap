<?php
namespace backend\controllers;

use Yii;
use common\components\override\Controller;
use yii\filters\AccessControl;
use yii\data\Pagination;
use common\forms\FetchPostForm;
use common\forms\ReadPostForm;
use common\forms\ApprovePostForm;
use common\forms\DisapprovePostForm;
use common\forms\WarningPostForm;
use common\forms\DeleteWarningPostForm;
use common\forms\DeletePostForm;
use yii\web\Response;
use common\forms\InsertPostForm;
use common\forms\FetchCategoryForm;
use common\forms\FetchLocationForm;

/**
 * PostController
 */
class PostController extends Controller
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
        $page = $request->get('page', 1);
        $limit = $request->get('per-page', 10);
        $offset = ($page - 1) * $limit;
        
        $data = [
            'offset' => $offset,
            'limit' => $limit
        ];
        $form = new FetchPostForm($data);
        $models = $form->fetch();
        $total = $form->count();
        $pages = new Pagination(['totalCount' => $total, 'defaultPageSize' => $limit]);
        return $this->render('index.tpl', [
            'models' => $models,
            'pages' => $pages
        ]);
    }

    public function actionUnchecked()
    {
        $request = Yii::$app->request;
        $page = $request->get('page', 1);
        $limit = $request->get('per-page', 10);
        $offset = ($page - 1) * $limit;
        $data = [
            'offset' => $offset,
            'limit' => $limit
        ];
        $form = new FetchPostForm($data);
        $models = $form->fetchUnchecked();
        $total = $form->count();
        $pages = new Pagination(['totalCount' => $total, 'defaultPageSize' => $limit]);
        return $this->render('index.tpl', [
            'models' => $models,
            'pages' => $pages
        ]);
    }

    public function actionInvalid()
    {
        $request = Yii::$app->request;
        $page = $request->get('page', 1);
        $limit = $request->get('per-page', 10);
        $offset = ($page - 1) * $limit;
        $data = [
            'offset' => $offset,
            'limit' => $limit
        ];
        $form = new FetchPostForm($data);
        $models = $form->fetchInvalid();
        $total = $form->count();
        $pages = new Pagination(['totalCount' => $total, 'defaultPageSize' => $limit]);
        return $this->render('index.tpl', [
            'models' => $models,
            'pages' => $pages
        ]);
    }

    /**
     * Show the detail of a post
     */
    public function actionView($id)
    {
        $form = new ReadPostForm(['id' => $id]);
        $model = $form->read();
        return $this->render('view.tpl', [
            'model' => $model
        ]);
    }

    /**
     * Approve a new post
     */
    public function actionApprove($id)
    {
        $form = new ApprovePostForm(['id' => $id]);
        if (!$form->approve()) {
            Yii::$app->session->setFlash('error', $form->getFirstError('id'));
        }
        $this->redirect(Yii::$app->request->getReferrer());
    }

    public function actionDisapprove($id)
    {
        $form = new DisapprovePostForm(['id' => $id]);
        if (!$form->disapprove()) {
            Yii::$app->session->setFlash('error', $form->getFirstError('id'));
        }
        $this->redirect(Yii::$app->request->getReferrer());
    }

    public function actionWarning($id)
    {
        $request = Yii::$app->request;
        $message = $request->post('message');
        $form = new WarningPostForm(['id' => $id, 'message' => $message]);
        if (!$form->report()) {
            Yii::$app->session->setFlash('error', 'Error');
        }
        $this->redirect(Yii::$app->request->getReferrer());
    }

    public function actionDeleteWarning($id)
    {
        $request = Yii::$app->request;
        $message = $request->post('message');
        $form = new DeleteWarningPostForm(['id' => $id]);
        if (!$form->delete()) {
            Yii::$app->session->setFlash('error', 'Error');
        }
        $this->redirect(Yii::$app->request->getReferrer());
    }

    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        if (!$request->isAjax) {
            return;
        }
        $form = new DeletePostForm([
            'id' => $id
        ]);
        
        return $this->renderJson($form->delete(), null, $form->getErrors());
    }

    public function actionCreate()
    {
        $this->view->registerJsFile(
            '@web/js/ckeditor/ckeditor.js',
            ['depends' => [\yii\web\JqueryAsset::className()]]
        );

        $this->view->registerJsFile(
            'vendors/iCheck/icheck.min.js',
            ['depends' => [\yii\web\JqueryAsset::className()]]
        );

        $this->view->registerCssFile(
            'vendors/iCheck/skins/flat/green.css',
            ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]
        );

        $this->view->registerJsFile('js/uploadimage.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

        $fetchCategoryForm = new FetchCategoryForm();
        $categories = $fetchCategoryForm->fetch();

        $fetchLocationForm = new FetchLocationForm();
        $locations = $fetchLocationForm->fetch();

        $model = new InsertPostForm(['scenario' => InsertPostForm::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $this->redirect(['post/index']);
            }
        }

        return $this->render('create.tpl', [
            'model' => $model,
            'user' => Yii::$app->user->getIdentity(),
            'categories' => $categories,
            'locations' => $locations
        ]);
    }
}
