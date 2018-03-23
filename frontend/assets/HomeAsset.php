<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class HomeAsset extends AssetBundle
{
    public $basePath = '@webPath';
    public $baseUrl = '@webUrl';
    public $css = [
        'static/home/css/main.css',
    ];

    public $js = [
        '//cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js',
        '//cdn.bootcss.com/respond.js/1.4.2/respond.min.js',
    ];

    public $depends = [
        'frontend\assets\AppAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];

    public $jsOptions = ['condition' => 'lte IE9'];
}
