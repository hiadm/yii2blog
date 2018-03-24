<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class LayerAsset extends AssetBundle
{
    public $basePath = '@webPath';
    public $baseUrl = '@webUrl';
    public $js = [
        'static/libs/layer/layer.js',
    ];


    public $depends = [
        'frontend\assets\AppAsset',
        //'yii\bootstrap\BootstrapPluginAsset'
    ];

}
