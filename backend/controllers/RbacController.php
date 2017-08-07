<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use yii\base\InvalidParamException;

class RbacController extends Controller
{
    public function actionInitRole()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        // Role: admin
        $admin = $auth->createRole('admin');
        $admin->description = 'Admin';
        $auth->add($admin);

        // Role: staff
        $sale = $auth->createRole('sale');
        $sale->description = 'Sale';
        $auth->add($sale);

        // Role: us_keeper
        $us_keeper = $auth->createRole('us_keeper');
        $us_keeper->description = 'US StoreKeeper';
        $auth->add($us_keeper);

        // Role: us_keeper
        $vn_keeper = $auth->createRole('vn_keeper');
        $vn_keeper->description = 'VN StoreKeeper';
        $auth->add($vn_keeper);

        $auth->addChild($admin, $sale);
        $auth->addChild($admin, $us_keeper);
        $auth->addChild($admin, $vn_keeper);
    }

    public function actionAssignAdmin($id)
    {
        $auth = Yii::$app->authManager;
        $admin = $auth->getRole('admin');
        $auth->assign($admin, $id);
    }

    public function actionAssignSale($id)
    {
        $auth = Yii::$app->authManager;
        $sale = $auth->getRole('sale');
        $auth->assign($sale, $id);
    }
}