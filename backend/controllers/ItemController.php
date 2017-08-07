<?php
namespace backend\controllers;

use Yii;
use common\components\override\Controller;
use yii\filters\AccessControl;
use yii\data\Pagination;
use common\forms\UpdateOrderItemForm;
// use common\forms\FetchOrderForm;
use common\forms\UpdateOrderItemProgress;
use yii\helpers\Url;
use common\models\OrderItem;
use common\forms\FetchOrderItemForm;

/**
 * ItemController
 */
class ItemController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['us_keeper', 'vn_keeper'],
                    ],
                ],
            ],
        ];
    }


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
        $form = new FetchOrderItemForm($data);
        $models = $form->fetch();
        $total = $form->count();
        $pages = new Pagination(['totalCount' => $total, 'defaultPageSize' => $limit]);
        $links = [
            'update_progress' => Url::to(['item/update-progress']),
        ];
        return $this->render('index.tpl', [
            'models' => $models,
            'pages' => $pages,
            'links' => $links,
            'form' => $form
        ]);
    }

    public function actionUpdateProgress($id)
    {
        $request = Yii::$app->request;
        $progress = $request->get('progress');
        $form = new UpdateOrderItemProgress(['id' => $id, 'progress' => $progress]);
        if (!$form->update()) {
            Yii::$app->session->setFlash('error', 'Error');
        }
        $this->redirect(Yii::$app->request->getReferrer());
    }

    public function actionUpdate($id)
    {
    	$this->view->registerJsFile(
            '@web/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js',
            ['depends' => [\yii\web\JqueryAsset::className()]]
        );
        
        $model = new UpdateOrderItemForm();
        $model->loadData($id);

        if ($model->load(Yii::$app->request->post())) {
        	$model->update();
        }

        $item = $model->getOrderItem();
        $customer = $item->customer;
        $order = $item->order;

        $links = [
            'update_progress' => Url::to(['item/update-progress']),
        ];
        return $this->render('update.tpl', [
            'item' => $item,
            'customer' => $customer,
            'order' => $order,
            'model' => $model,
            'links' => $links,
            'template' => "step/" . $item->progress . ".tpl"
        ]);
    }
}