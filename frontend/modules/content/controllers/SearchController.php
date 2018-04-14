<?php
namespace frontend\modules\content\controllers;
use frontend\controllers\BaseController;
use frontend\models\SearchArticle;
use Yii;

class SearchController extends BaseController
{
    public $layout = '/layout';

    public function actionIndex(){
        //获取关键字
        $words = htmlspecialchars(Yii::$app->request->get('words'));
        if(empty($words))
            return $this->redirect(['/']);

        $data = SearchArticle::search($words);


        return $this->render('index',[
            'articles' => $data['articles'],
            'pagination' => $data['pagination']
        ]);
    }
}