<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace console\controllers;

use yii\console\Controller;
use common\models\Image;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ImageController extends Controller
{
    /**
     * @param string $size - format intxint
     * yii image/generate-thumb $size
     */
    public function actionGenerateThumb($size)
    {
		$images = Image::find()->all();
		foreach ($images as $image) {
			echo "=========== Process image #" . $image->getId() . "\n";
			$image->saveThumb($size);
		}
    }
}
