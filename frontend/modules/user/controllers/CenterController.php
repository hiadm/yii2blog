<?php
namespace frontend\modules\user\controllers;
use frontend\controllers\BaseController;
use frontend\models\Article;
use frontend\models\Attention;
use frontend\models\Collect;
use frontend\models\Favorite;
use frontend\models\Subject;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;
use yii\web\Response;

class CenterController extends BaseController
{
    /**
     *
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index', 'cancel-collect'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            /*'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],*/
        ];
    }


    public function actionIndex(){
        //获取个人信息
        $user = Yii::$app->user->identity;


        //获取文章信息
        $type = Yii::$app->request->get('type');
        $types = ['collect','likes','attention'];
        if (empty($type) || !in_array($type, $types)){
            //矫正参数
            $type = 'collect';
        }

        $articles = [];
        $subjects = [];
        switch ($type) {
            case 'collect':
                $articles = Article::getCollects($user->getId());
                $articles['type'] = 'collect';
                break;
            case 'likes':
                $articles = Article::getLikes($user->getId());
                $articles['type'] = 'likes';
                break;
            case 'attention':
                $subjects = Subject::getAttentions($user->getId());
                break;
        }




        return $this->render('index',[
            'user' => $user,
            'articles' => $articles,
            'subjects' => $subjects
        ]);
    }

    /**
     * 取消收藏
     */
    public function actionCancelCollect(){
        if (Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;

            //文章id
            $aid = Yii::$app->request->post('id');
            //用户id
            $uid = Yii::$app->user->getId();

            $collect = Collect::find()
                ->where(['user_id'=>$uid])
                ->andWhere(['article_id'=>$aid])
                ->one();

            if (!$collect)
                return ['errcode'=> 1, 'message'=>'操作无效'];

            $ret = $collect->delete();
            if($ret === false)
                return ['errcode'=>1, 'message'=>'取消收藏失败'];
            return ['errcode'=>'0', 'message'=>'取消收藏成功。'];




        }
        return false;
    }

    /**
     * 取消喜欢
     */
    public function actionCancelLikes(){
        if (Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;

            //文章id
            $aid = Yii::$app->request->post('id');
            //用户id
            $uid = Yii::$app->user->getId();

            $collect = Favorite::find()
                ->where(['user_id'=>$uid])
                ->andWhere(['article_id'=>$aid])
                ->one();

            if (!$collect)
                return ['errcode'=> 1, 'message'=>'操作无效'];

            $ret = $collect->delete();
            if($ret === false)
                return ['errcode'=>1, 'message'=>'取消喜欢失败'];
            return ['errcode'=>'0', 'message'=>'取消喜欢成功。'];




        }
        return false;
    }

    /**
     * 取消关注
     */
    public function actionCancelAttention(){
        if (Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;

            //文章id
            $sid = Yii::$app->request->post('id');
            //用户id
            $uid = Yii::$app->user->getId();

            $collect = Attention::find()
                ->where(['user_id'=>$uid])
                ->andWhere(['subject_id'=>$sid])
                ->one();

            if (!$collect)
                return ['errcode'=> 1, 'message'=>'操作无效'];

            $ret = $collect->delete();
            if($ret === false)
                return ['errcode'=>1, 'message'=>'取消关注失败'];
            return ['errcode'=>'0', 'message'=>'取消关注成功。'];




        }
        return false;
    }
}