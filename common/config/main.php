<?php
function dd($arr) {
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
    die();
}
function d($arr) {
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],        
    ],
];
