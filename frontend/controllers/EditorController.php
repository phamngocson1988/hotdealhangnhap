<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\View;
use yii\web\UploadedFile;
use common\forms\UploadImageForm;
use common\forms\FetchImageForm;

/**
 * EditorController
 */
class EditorController extends Controller
{
	public $enableCsrfValidation = false;
    public function actionIndex()
    {
        $this->view->registerJsFile(
            '@web/js/ckeditor/ckeditor/ckeditor.js',
            ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]
        );
        $this->view->registerJsFile("@web/js/uploadimage.js", ['depends' => [\yii\web\JqueryAsset::className()], 'position' => View::POS_HEAD]);
        return $this->render('index.tpl');
    } 

    public function actionList()
    {
    	$request = Yii::$app->request;
    	$fetchData = [
            'user_id' => Yii::$app->user->getId(),
        ];
        $fetchMediaForm = new FetchImageForm($fetchData);
        $list = $fetchMediaForm->fetch();
        $total = $request->get('total');
        if ($total === null) {
            $total = $fetchMediaForm->count();    
        }
        return $this->renderPartial('list.tpl', ['list' => $list]);
    }

    public function actionUploadImage()
    {
        $model = new UploadImageForm();

        if (Yii::$app->request->isPost) {
            $model->imageFiles = UploadedFile::getInstancesByName('upload');

            if ($model->upload()) {
            	$images = $model->getImages();
            	$image = reset($images);
                echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction(1, '".$image->getUrl()."', '');</script>";
                die;
            }
            dd($model);
        }
    }
}
