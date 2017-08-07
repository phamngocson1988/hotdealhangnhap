<?php

namespace backend\assets;

use yii\web\AssetBundle;
use backend\assets\AppAsset;
/**
 * Main backend application asset bundle.
 */
class LoginAsset extends AppAsset
{
    public $css = [
        'vendors/animate.css/animate.min.css',
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}