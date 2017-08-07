<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\data\Pagination;
use common\forms\UploadImageForm;
use yii\web\UploadedFile;
use yii\web\Response;
use common\forms\FetchImageForm;
use common\forms\DeleteImageForm;

/**
 * ImageController
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
        if ($request->isAjax) {
            $offset = $request->get('offset', 1);
            $limit = $request->get('limit', 8);
            $data = [
                'offset' => $offset,
                'limit' => $limit
            ];
            $form = new FetchImageForm($data);
            $models = $form->fetch();
            $total = $form->count();
            $html = "";
            foreach ($models as $model) {
                $html .= $this->renderPartial('_item.tpl',['model' => $model]);
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'status' => true,
                'items' => $html,
                'total' => $total
            ];
        } else {
            $this->view->registerJsFile('js/ajax_paging.js', ['depends' => ['\yii\bootstrap\BootstrapAsset']]);
        }
        
        return $this->render('index.tpl');
    }    

    public function actionUpload()
    {
        $this->view->registerCssFile('vendors/dropzone/dist/min/dropzone.min.css', ['depends' => ['\yii\bootstrap\BootstrapAsset']]);
        $this->view->registerJsFile('vendors/dropzone/dist/min/dropzone.min.js', ['depends' => ['\yii\bootstrap\BootstrapAsset']]);
        return $this->render('upload.tpl', [
            // 'model' => $model,
        ]);

    }

    public function actionAjaxUpload()
    {
        $request = Yii::$app->request;
        if (!$request->isAjax) {
            return;
        }
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

    public function actionAjaxDelete($id)
    {
        $request = Yii::$app->request;
        if (!$request->isAjax) {
            return;
        }
        $model = new DeleteImageForm(['id' => $id]);
        
        if ($model->delete()) {
            $result['status'] = true;
        } else {
            $result['status'] = false;
            $result['error'] = $model->getErrors();
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }
}
