<?php
namespace frontend\modules\content\controllers;
use frontend\models\BackendUser;
use frontend\controllers\BaseController;
use frontend\models\Article;
use frontend\models\Favorite;
use frontend\models\Collect;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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

        //如果是登录用户判断是否已喜欢
        $article['favorite'] = false;
        $article['collect'] = false;
        if (!Yii::$app->user->isGuest){
            $article['favorite'] = Favorite::isExists($article['id'],Yii::$app->user->getId());
            $article['collect'] = Collect::isExists($article['id'],Yii::$app->user->getId());

        }



        //获取上一篇和下一篇
        $prevAndNext = Article::getPreviousAndNext($article['id'],$article['subject_id']);



        //获取用户详情
        $user = BackendUser::getAuthor($article['created_by']);


        //添加阅读次数
        $article->updateCounters(['visited'=>1]);




        $this->view->title = $article['title'];
        $this->view->params['description'] = $article['brief'];
        return $this->render('view',[
            'article' => $article,
            'user'=>$user,
            'prevAndNext' => $prevAndNext,
        ]);
    }


    /**
     * ajax 添加喜欢
     */
    public function actionAjaxFavorite(){
        if (Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;

            //获取文章id
            $aid = (int)Yii::$app->request->get('aid');
            if ($aid <= 0)
                throw new BadRequestHttpException('请求参数错误。');

            //判断是否登陆
            if (Yii::$app->user->isGuest){
                return ['errcode'=>0, 'message'=>'请先登录，再做此操作。'];
            }

            //判断是否已经添加喜欢
            $uid = Yii::$app->user->getId();
            if (Favorite::isExists($aid, $uid)){
                return ['errcode'=>0, 'message'=>'已经添加喜欢，不要重复提交。'];
            }

            //保存数据
            $favorite = new Favorite();
            $favorite->article_id = $aid;
            $favorite->user_id = $uid;

            if($favorite->save()){
                //添加成功
                return ['errcode'=>0, 'message'=>'添加喜欢成功。'];
            }
            return ['errcode'=>1, 'message'=>'添加喜欢失败，请重试。'];


        }
        return false;
    }

    /**
     * ajax 添加收藏
     */
    public function actionAjaxCollect(){
        if (Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;

            //获取文章id
            $aid = (int)Yii::$app->request->get('aid');
            if ($aid <= 0)
                throw new BadRequestHttpException('请求参数错误。');

            //判断是否登陆
            if (Yii::$app->user->isGuest){
                return ['errcode'=>0, 'message'=>'请先登录，再做此操作。'];
            }

            //判断是否已经添加喜欢
            $uid = Yii::$app->user->getId();
            if (Collect::isExists($aid, $uid)){
                return ['errcode'=>0, 'message'=>'已经添加收藏，不要重复提交。'];
            }

            //保存数据
            $favorite = new Collect();
            $favorite->article_id = $aid;
            $favorite->user_id = $uid;

            if($favorite->save()){
                //添加成功
                return ['errcode'=>0, 'message'=>'添加收藏成功。'];
            }
            return ['errcode'=>1, 'message'=>'添加收藏失败，请重试。'];


        }
        return false;
    }
}