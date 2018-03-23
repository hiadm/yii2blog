<?php
namespace frontend\modules\user\controllers;
use yii\web\Controller;

class CenterController extends Controller
{
    public function actionIndex(){
        return $this->render('index');
    }
}