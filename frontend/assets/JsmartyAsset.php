<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class JsmartyAsset extends AssetBundle
{
    public $basePath = '@webPath';
    public $baseUrl = '@webUrl';

    public $js = [
        'static\libs\jsmart\smart.min.js',
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];

}
