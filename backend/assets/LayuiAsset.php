<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class LayuiAsset extends AssetBundle
{
    public $basePath = '@webPath';
    public $baseUrl = '@webUrl';

    public $css = [
        'static/libs/layui/css/layui.css',
    ];
    public $js = [
        'static/libs/layui/layui.js',
    ];
    public $depends = [
        'backend\assets\AppAsset',
    ];
}
