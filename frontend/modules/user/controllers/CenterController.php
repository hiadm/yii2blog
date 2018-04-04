<?php
namespace frontend\modules\user\controllers;
use frontend\controllers\BaseController;
use frontend\models\Article;
use frontend\models\Attention;
use frontend\models\Collect;
use frontend\models\Favorite;
use frontend\models\Subject;
use frontend\modules\user\models\Setting;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;
use yii\web\Response;
use common\components\Upload as NewUpload;
use yii\web\MethodNotAllowedHttpException;

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
                'only' => [
                    'index',
                    'cancel-collect',
                    'cancel-likes',
                    'cancel-attention',
                    'reset-password',
                    'reset-email',
                    'reset-photo'
                ],
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'cancel-collect',
                            'cancel-likes',
                            'cancel-attention',
                            'reset-password',
                            'reset-email',
                            'reset-photo'
                        ],

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


    /**
     * 修改密码
     */
    public function actionResetPassword(){
        //获取个人信息
        $user = Yii::$app->user->identity;

        $model = new Setting();
        $model->scenario = Setting::RESET_PASSOWRD;

        if($model->load(Yii::$app->request->post()) && $model->store()){
            Yii::$app->session->setFlash('info','密码重置成功。');
            $this->refresh();
        }


        return $this->render('reset-password',[
            'user' => $user,
            'model' => $model,
        ]);
    }

    /**
     * 修改邮箱
     */

    public function actionResetEmail(){
        //获取个人信息
        $user = Yii::$app->user->identity;

        $model = new Setting();
        $model->scenario = Setting::RESET_EMAIL;

        if($model->load(Yii::$app->request->post()) && $model->storeEmail()){
            Yii::$app->session->setFlash('info','邮箱重置成功。');
            $this->refresh();
        }


        return $this->render('reset-email',[
            'user' => $user,
            'model' => $model,
        ]);
    }

    /**
     * 修改头像
     */
    public function actionResetPhoto(){
        //获取个人信息
        $user = Yii::$app->user->identity;

        $model = new Setting();
        $model->scenario = Setting::SET_PHOTO;

        if($model->load(Yii::$app->request->post()) && $model->savePhoto()){
            Yii::$app->session->setFlash('info', '修改头像成功。');
            $this->refresh();
        }

        return $this->render('reset-photo',[
            'user' => $user,
            'model' => $model
        ]);
    }



    /**
     * 上传专题图片
     */
    public function actionUpload(){
        $this->enableCsrfValidation = false;
        if(Yii::$app->request->isPost){
            Yii::$app->response->format = Response::FORMAT_JSON;
            try {
                Yii::$app->response->format = Response::FORMAT_JSON;

                $model = new NewUpload();

                $info = $model->upImage('tmp_');

                if ($info && is_array($info)) {
                    return $info;
                } else {
                    return ['code' => 1, 'msg' => 'error'];
                }

            } catch (\Exception $e) {
                return ['code' => 1, 'msg' => $e->getMessage()];
            }
        }
        throw new MethodNotAllowedHttpException('请求方式不被允许。');

    }

    /**
     * 订阅VIP
     */
}