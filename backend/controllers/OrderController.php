<?php
namespace backend\controllers;

use Yii;
use common\components\override\Controller;
use yii\filters\AccessControl;
use yii\data\Pagination;
use common\forms\InsertOrderForm;
use common\forms\UpdateOrderForm;
use common\forms\FetchOrderForm;
use common\forms\UpdateOrderItemProgress;
use yii\helpers\Url;
use common\models\Order;
use common\forms\FetchOrderItemForm;
use common\forms\DeleteOrderForm;
/**
 * OrderController
 */
class OrderController extends Controller
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
                        'roles' => ['sale'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
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
        $data = $request->get();
        $page = $request->get('page', 1);
        $limit = $request->get('per-page', 10);
        $offset = ($page - 1) * $limit;
        
        unset($data['page']);
        unset($data['per-page']);
        $data['offset']  = $offset;
        $data['limit'] = $limit;

        if (!Yii::$app->user->can('admin') && Yii::$app->user->can('sale')) {
            $data['created_by'] = Yii::$app->user->id;
        }
        $form = new FetchOrderForm($data);
        $models = $form->fetch();
        $total = $form->count();
        $pages = new Pagination(['totalCount' => $total, 'defaultPageSize' => $limit]);
        $links = [
            'update_progress' => Url::to(['order/update-progress']),
        ];
        

        return $this->render('index.tpl', [
            'models' => $models,
            'pages' => $pages,
            'links' => $links,
            'form' => $form
        ]);
    }

    public function actionCreate()
    {
        $model = new InsertOrderForm();
        if ($model->load(Yii::$app->request->post())) {
            // $model->prepay + 1;
            // dd($model);
            if ($model->save()) {
                return $this->redirect(['order/index']);
            }
        }

        $links = [
            'find_customer' => Url::to(['customer/find-by-term'])
        ];

        $this->view->registerJsFile(
            '@web/js/jquery.number.min.js',
            ['depends' => [\yii\web\JqueryAsset::className()]]
        );
        return $this->render('create.tpl', [
            'model' => $model,
            'links' => $links
        ]);
    }

    public function actionUpdate($id)
    {
        $model = new UpdateOrderForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['order/index']);
            }
        }
        $model->loadData($id);
        $links = [
            'find_customer' => Url::to(['customer/find-by-term'])
        ];
        $this->view->registerJsFile(
            '@web/js/jquery.number.min.js',
            ['depends' => [\yii\web\JqueryAsset::className()]]
        );
        return $this->render('update.tpl', [
            'model' => $model,
            'links' => $links
        ]);
    }

    /**
     * Show the detail of a post
     */
    public function actionView($id)
    {
        $model = Order::findOne($id);
        return $this->render('view.tpl', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        // $request = Yii::$app->request;
        // if (!$request->isAjax) {
        //     return;
        // }
        // $form = new DeleteOrderForm([
        //     'id' => $id
        // ]);
        
        // return $this->renderJson($form->delete(), null, $form->getErrors());

        $form = new DeleteOrderForm(['id' => $id]);
        if (!$form->delete()) {
            Yii::$app->session->setFlash('error', 'Error');
        }
        return $this->redirect(Yii::$app->request->getReferrer());
    }
}
