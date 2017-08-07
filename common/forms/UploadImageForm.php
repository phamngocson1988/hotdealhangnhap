<?php
namespace common\forms;

use yii\base\Model;
use yii\web\UploadedFile;
use yii\imagine\Image;
use common\models\Image as TImage;
use yii\helpers\ArrayHelper;
use common\components\helpers\FileHelper;
use Yii;


class UploadImageForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    protected $thumbnails = [
        'small' => '50x50', 
        'medium' => '100x100',
        'large' => '150x150',
        'xlarge' => '300x300',
    ];

    private $_images = [];

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    public function getThumbnails()
    {
        return (array)$this->thumbnails;
    }

    public function upload()
    {
        if (!$this->validate()) { 
            return false;
        }

        try {
            $transaction = Yii::$app->db->beginTransaction();
            foreach ($this->imageFiles as $file) {
                // Save database.
                $fileModel = new TImage();
                $fileModel->name = $file->baseName;
                $fileModel->extension = $file->extension;
                $fileModel->size = $file->size;
                $fileModel->created_at = strtotime('now');
                $fileModel->created_by = Yii::$app->user->id;
                $fileModel->save();

                // Save to disk
                $absolutePath = $fileModel->getAbsolutePath();
                FileHelper::createDirectory($absolutePath);
                $filePath = $fileModel->getPath();
                $file->saveAs($filePath);

                foreach ($this->getThumbnails() as $thumbSize) {
                    $fileModel->saveThumb($thumbSize);
                }
                $this->_images[] = $fileModel;
            }
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    public function getImages()
    {
        return (array)$this->_images;
    }
}