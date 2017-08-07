<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;
/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendors/font-awesome/css/font-awesome.min.css',
        'vendors/nprogress/nprogress.css',
        'vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css',
        'css/custom.min.css',
        // ['css/ace.min.css', 'class' => 'ace-main-stylesheet', 'id' => 'main-ace-style'],
        // ['css/ace-part2.min.css', 'condition' => 'lte IE 9', 'class' => 'ace-main-stylesheet'],
        // ['css/css/ace-ie.min.css', 'condition' => 'lte IE 9'],
    ];
    public $js = [
        'vendors/fastclick/lib/fastclick.js',
        'vendors/nprogress/nprogress.js',
        'vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js',
        'js/custom.min.js'
        // ['js/ace-extra.min.js', 'position' => View::POS_HEAD, 'depends' => null],
        // ['js/html5shiv.min.js', 'condition' => 'lte IE 8', 'position' => View::POS_HEAD, 'depends' => null],
        // ['js/respond.min.js', 'condition' => 'lte IE 8', 'position' => View::POS_HEAD, 'depends' => null],
    ];

    // public $jsOptions = ['position' => View::POS_HEAD];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}