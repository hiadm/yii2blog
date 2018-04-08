<?php
namespace frontend\modules\content\controllers;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use Yii;
use yii\web\Response;
use frontend\models\Comment;

class CommentController extends Controller
{
    /**
     * 提交文章评论
     */
    public function actionAjaxCommit(){
        if (Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;

            //是否是登录用户
            if (Yii::$app->user->isGuest)
                return ['errcode'=>1, 'message'=>'请先登录，再做此操作。'];

            //获取用户id
            $uid = Yii::$app->user->getId();
            $aid = (int)Yii::$app->request->post('aid');

            //检测上次评论时间是否超过2分钟
            if(!Comment::canCommit($uid)){
                return ['errcode'=>1, 'message'=>'您刚刚评论过，请2分钟后再评论。'];
            }


            $content = trim(Yii::$app->request->post('content'));
            if ($aid <= 0 || empty($content))
                throw new BadRequestHttpException('请求参数错误。');

            $comment = new Comment();
            $comment->user_id = $uid;
            $comment->article_id = $aid;
            $comment->content = $content;

            if($comment->save()){
                return ['errcode'=>0, 'message'=>'提交评论成功','data'=>[
                    'photo' => !empty(Yii::$app->user->identity->photo)?Yii::$app->user->identity->photo:Yii::$app->params['userPhoto'],
                    'username' => Yii::$app->user->identity->username,
                    'time' => '刚刚',
                    'content' => Html::encode($content),
                    'cid' => $comment->id,
                ]];
            }
            return ['errcode'=>1, 'message'=>'提交评论失败，请重试。'];
        }
        return false;
    }


    /**
     * 评论点赞
     */
    public function actionAjaxZan(){
        if (Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;

            //获取评论id
            $cid = (int) Yii::$app->request->post('cid');
            if ($cid <= 0)
                throw new BadRequestHttpException('传递参数错误。');

            //是否登录
            if (Yii::$app->user->isGuest)
                return ['errcode'=>1, 'message'=>'请先登录再做此操作。'];



            $ret = Comment::findOne($cid)->updateCounters(['likes'=>1]);
            if ($ret !== false)
                return ['errcode'=>0, 'message'=>'点赞成功'];
            return ['errcode'=>1, 'message'=>'点赞失败，请重试。'];

        }
        return false;
    }
}