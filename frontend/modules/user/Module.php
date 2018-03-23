<?php

namespace frontend\modules\user;

/**
 * user module definition class
 */
class Module extends \yii\base\Module
{
    public $layout = '/layout';
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\user\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
