<?php

namespace frontend\modules\content;

/**
 * content module definition class
 */
class Module extends \yii\base\Module
{
    public $layout = '/layout';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\content\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
