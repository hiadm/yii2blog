<?php
namespace frontend\controllers;
use yii\web\Controller;
use Yii;

class BaseController extends Controller
{
    public function init()
    {
        parent::init();

        $userPhoto = Yii::$app->params['userPhoto'];

        //默认头像
        $this->view->params['userPhoto'] = $userPhoto;
    }
}