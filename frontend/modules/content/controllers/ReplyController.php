<?php
namespace frontend\modules\content\controllers;
use frontend\models\Reply;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use Yii;
use yii\web\Response;

class ReplyController extends Controller
{
    //保存回复内容
    public function actionAjaxCommit(){
        //echo 'asd';die;
        if (Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;

            //是否是登录用户、
            if (Yii::$app->user->isGuest)
                return ['errcode'=>1, 'message'=> '请先登录，再进行回复。'];


            //接收参数并基本验证
            $aid = (int) Yii::$app->request->post('aid');
            $cid = (int) Yii::$app->request->post('cid');
            $txt = Yii::$app->request->post('txt');

            //检测是否处在安全时间内（2分钟之外）
            if(!Reply::canCommit($aid, $cid)){
                return ['errcode'=>1, 'message'=>'您刚刚回复过，请2分钟后在回复。'];
            }


            if ($aid <= 0 || $cid <= 0 || empty($txt))
                throw new BadRequestHttpException('请求参数错误。');

            //保存数据
            $reply = new Reply();
            $reply->article_id = $aid;
            $reply->comment_id = $cid;
            $reply->content = $txt;
            $reply->user_id = Yii::$app->user->getId();

            if ($reply->save()){
                return ['errcode'=>0, 'message'=>'回复成功。', 'data' => [
                    'username' => Yii::$app->user->identity->username,
                    'txt' => Html::encode($txt),
                    'time' => '刚刚',

                ]];
            }
            return ['errcode' => 1, 'message' => '回复失败，请重试。'];

            
            
        }
        return false;
    }
}