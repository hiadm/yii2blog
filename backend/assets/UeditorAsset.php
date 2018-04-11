<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class UeditorAsset extends AssetBundle
{
    public $basePath = '@webPath';
    public $baseUrl = '@webUrl';

    public $css = [
        'static/libs/umeditor/themes/default/css/umeditor.css'
    ];

    public $js = [
        'static/libs/umeditor/umeditor.config.js',
        'static/libs/umeditor/umeditor.min.js',
    ];
    public $depends = [
        'backend\assets\AppAsset',
    ];
}
