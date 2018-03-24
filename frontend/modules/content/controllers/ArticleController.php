<?php
namespace frontend\modules\content\controllers;
use frontend\models\BackendUser;
use frontend\controllers\BaseController;
use frontend\models\Article;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class ArticleController extends BaseController
{

    /**
     * 文章内容页
     */
    public function actionView(){
        $id = (int) Yii::$app->request->get('id');
        if($id <= 0){
            throw new BadRequestHttpException('请求参数错误。');
        }



        //获取文章
        $article = Article::getDetail($id);
        if (empty($article))
            throw new NotFoundHttpException('没有相关数据。');
        //var_dump($article);die;


        //获取上一篇和下一篇
        $prevAndNext = Article::getPreviousAndNext($article['id'],$article['subject_id']);



        //获取用户详情
        $user = BackendUser::getAuthor($article['created_by']);




        $this->view->title = $article['title'];
        $this->view->params['description'] = $article['brief'];
        return $this->render('view',[
            'article' => $article,
            'user'=>$user,
            'prevAndNext' => $prevAndNext,
        ]);
    }
}