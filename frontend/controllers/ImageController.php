<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use common\forms\UploadImageForm;
use common\forms\FetchImageForm;
use yii\web\View;
use yii\web\Response;

/**
 * FileController
 */
class ImageController extends Controller
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
                        'actions' => ['ajax-upload-image'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'ajax-upload-image' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionAjaxUploadImage()
    {
        $request = Yii::$app->request;
        $model = new UploadImageForm();
        $attribute = $request->post('name', 'imageFiles');
        $model->imageFiles = UploadedFile::getInstancesByName($attribute);
        $result = ['status' => false];
        if ($model->validate() && $model->upload()) {
            $result['status'] = true;
            if ($request->post('review_width') && $request->post('review_height')) {
                $images = $model->getImages();
                $size = sprintf("%sx%s", $request->post('review_width'), $request->post('review_height'));

                $imageArray = [];
                foreach ($images as  $image) {
                    $info = [];
                    $info['id'] = $imageId = $image->getId();
                    $info['thumb'] = $image->getUrl($size);
                    $info['src'] = $image->getUrl();
                    $imageArray[$imageId] = $info;
                }

                $result['images'] = $imageArray;
            }
        } else {
            $result['error'] = $model->getErrors();
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }
}
