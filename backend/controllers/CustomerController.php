<?php
namespace backend\controllers;

use Yii;
use common\components\override\Controller;
use common\forms\FetchCustomerForm;
use common\forms\CreateCustomerForm;
use common\forms\UpdateCustomerForm;
use yii\data\Pagination;
use yii\helpers\Url;
use common\models\Customer;

/**
 * Customer controller
 */
class CustomerController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
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
        $form = new FetchCustomerForm($data);
        $models = $form->fetch();
        $total = $form->count();
        $pages = new Pagination(['totalCount' => $total, 'defaultPageSize' => $limit]);
        $links = [
            'view' => Url::to(['customer/view']),
        ];
        return $this->render('index.tpl', [
            'models' => $models,
            'pages' => $pages,
            'links' => $links
        ]);
    }

    public function actionFindByTerm()
    {
        $request = Yii::$app->request;
        if (!$request->isAjax) {
            return;
        }
        
        $term = $request->get('term');
        $model = Customer::findOne(['email' => $term]);
        if ($model) {
            $data['name'] = $model->name;
            $data['email'] = $model->email;
            $data['address'] = $model->address;
            $data['phone'] = $model->phone;
            return $this->renderJson(true, $data);
        } else {
            return $this->renderJson(false);
        }
    }

    public function actionUpdate($id)
    {
        $model = new UpdateCustomerForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['customer/index']);
            }
        } else {
            $model->loadData($id);
        }
        return $this->render('update.tpl', [
            'model' => $model,
        ]);

    }

    public function actionCreate()
    {
        $model = new CreateCustomerForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['customer/index']);
            }
        }

        return $this->render('create.tpl', [
            'model' => $model,
        ]);
    }
}
