<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\forms\FetchUserForm;
use backend\forms\SignupForm;
use yii\data\Pagination;
use yii\helpers\Url;
use common\forms\UpdateProfileForm;
use common\forms\ChangePasswordForm;
use common\forms\ChangeAvatarForm;
use yii\web\Response;
use common\forms\FetchPostForm;

/**
 * UserController
 */
class UserController extends Controller
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
                        'actions' => ['create', 'staff'],
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'profile', 'update-profile', 'change-password', 'change-avatar'],
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
        $form = new FetchUserForm($data);
        $models = $form->fetchMember();
        $total = $form->count();
        $pages = new Pagination(['totalCount' => $total, 'defaultPageSize' => $limit]);
        return $this->render('index.tpl', [
            'models' => $models,
            'pages' => $pages
        ]);
    }

    public function actionStaff()
    {
        $request = Yii::$app->request;
        $page = $request->get('page', 1);
        $limit = $request->get('per-page', 10);
        $offset = ($page - 1) * $limit;
        
        $data = [
            'offset' => $offset,
            'limit' => $limit
        ];
        $form = new FetchUserForm($data);
        $models = $form->fetchStaff();
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
        return $this->render('view.tpl');
    }

    public function actionCreate()
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRoles();
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                $roleName = Yii::$app->request->post('role');
                if ($roleName && array_key_exists($roleName, $roles)) {
                    $role = $roles[$roleName];
                    $auth->assign($role, $user->id);
                }
                return $this->redirect(['user/staff']);
            }
        }

        return $this->render('create.tpl', [
            'model' => $model,
            'roles' => $roles,
        ]);

    }

    public function actionProfile()
    {
        $request = Yii::$app->request;
        $this->view->registerJsFile('js/uploadimage.js', ['depends' => ['\yii\web\JqueryAsset']]);
        $this->view->registerJsFile('js/ajax_submit.js', ['depends' => ['\yii\web\JqueryAsset']]);
        $user = Yii::$app->user->getIdentity();

        // Profile form
        $profile = new UpdateProfileForm();
        $profile->name = $user->name;
        $profile->phone = $user->phone;
        $profile->gender = $user->gender;
        $profile->address = $user->address;
        $profile->year_of_birth = $user->year_of_birth;

        // Password form
        $password = new ChangePasswordForm();

        
        $page = $request->get('page', 1);
        $limit = $request->get('per-page', 20);
        $offset = ($page - 1) * $limit;
        
        // List of posts
        $data = [
            'offset' => $offset,
            'limit' => $limit,
            'user_id' => Yii::$app->user->id,
        ];
        $listForm = new FetchPostForm($data);
        $posts = $listForm->fetchByUser();
        $totalPost = $listForm->count();
        $postPages = new Pagination(['totalCount' => $totalPost, 'defaultPageSize' => $limit]);


        $links = [
            'change_avatar' => Url::to(['user/change-avatar']),
            'change_password' => Url::to(['user/change-password']),
            'update_profile' => Url::to(['user/update-profile']),
            'upload_image' => Url::to(['image/ajax-upload']),
        ];
        return $this->render('profile.tpl', [
            'profile' => $profile,
            'password' => $password,
            'user' => $user,
            'links' => $links,
            'posts' => $posts,
            'pages' => $postPages

        ]);
    }

    public function actionUpdateProfile()
    {
        $request = Yii::$app->request;
        if (!$request->isAjax) {
            return;
        }
        $post = $request->post();
        $profile = new UpdateProfileForm();
        if ($profile->load($post) && $profile->save()) { 
            $result['status'] = true;
        } else {
            $result['status'] = false;
            $result['error'] = $profile->getErrors();
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }

    public function actionChangePassword()
    {
        $request = Yii::$app->request;
        if (!$request->isAjax) {
            return;
        }

        $post = $request->post();
        $model = new ChangePasswordForm();
        
        if ($model->load($post) && $model->change()) {
            $result['status'] = true;
        } else {
            $result['status'] = false;
            $result['error'] = $model->getErrors();
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }

    public function actionChangeAvatar()
    {
        $request = Yii::$app->request;
        if (!$request->isAjax) {
            return;
        }

        $imageId = $request->post('image_id');
        $model = new ChangeAvatarForm([
            'image_id' => $imageId
        ]);
        
        if ($model->change()) {
            $result['status'] = true;
        } else {
            $result['status'] = false;
            $result['error'] = $model->getErrors();
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }
}
