<?php
namespace frontend\modules\content\controllers;
use frontend\controllers\BaseController;
use frontend\models\Article;
use frontend\models\Attention;
use frontend\models\Subject;
use yii\web\BadRequestHttpException;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SubjectController extends BaseController
{

    /**
     * 专题列表
     */
    public function actionSublist(){
        $type = Yii::$app->request->get('type');
        if (!isset($type))
            $type = 'hot';

        //获取专题数据
        $data = Subject::getSubjects($type);

        if(!Yii::$app->user->isGuest){
            //获取当前用户专注的专题id
            $attention = Attention::getAttention();

            //给已关注的专题添加一个isAttention 记号
            foreach ($data['subjects'] as $key=>$val){
                if(in_array($data['subjects'][$key]['id'], $attention))
                    $data['subjects'][$key]['isAttention'] = true;
            }

        }

        return $this->render('sublist',[
            'type' => $type,
            'subjects' => $data['subjects'],
            'pagination' => $data['pagination'],

        ]);
    }

    /**
     * 专题主页
     */
    public function actionView(){
        $id = (int)Yii::$app->request->get('id');
        if ($id <= 0)
            throw new BadRequestHttpException('请求参数错误.');



        //获取专题信息
        $subject = Subject::getDetail($id);

        //如果是登陆用户获取是否已关注
        $attend = false;
        if (!Yii::$app->user->isGuest){
            $attend = (bool)Attention::find()
                ->select('id')
                ->where(['subject_id' => $id])
                ->andWhere(['user_id' => Yii::$app->user->getId()])
                ->scalar();

        }

        //获取专题关注数目
        $attentionNum = Attention::getAttentionNum($id);

        if (!$subject)
            throw new NotFoundHttpException('没有相关数据。');

        //获取文章数据
        $articlesData = Article::getSubjectArticles($id);



        return $this->render('view',[
            'subject' => $subject,
            'articles' => $articlesData['articles'],
            'pagination' => $articlesData['pagination'],
            'attentionNum' => $attentionNum,
            'attend' => $attend
        ]);
    }

    /**
     * ajax search subject
     */
    public function actionAjaxSubjects(){
        if (Yii::$app->request->isAjax){

            Yii::$app->response->format = Response::FORMAT_JSON;


            $name = Yii::$app->request->get('name');
            if (empty($name))
                return ['errcode' => '1', 'message' => '请求参数错误.'];

            $subjects = Subject::SearchSubjects($name);



            if (empty($subjects))
                return ['errcode'=>1, 'message'=>'没有相关数据.'];

            if(!Yii::$app->user->isGuest){
                //获取当前用户专注的专题id
                $attention = Attention::getAttention();

                //给已关注的专题添加一个isAttention 记号
                foreach ($subjects as $key=>$val){
                    if(in_array($subjects[$key]['id'], $attention))
                        $subjects[$key]['isAttention'] = true;
                }

            }





            return ['errcode'=>0, 'data'=>$subjects];
        }
        return false;

    }


    /**
     * 添加关注
     */
    public function actionAttention(){
        //判断是否登录
        if (Yii::$app->user->isGuest){
            return $this->redirect(['/index/login']);
        }
        //获取专题id 判断数据类型
        $sid = (int) Yii::$app->request->get('sid');
        if ($sid <= 0)
            throw new BadRequestHttpException('请求参数错误.');

        //添加数据
        $attention = new Attention();
        if (!$attention->store($sid)){
            //关注失败
            Yii::$app->session->setFlash('info','关注失败，请重试。');
        }else
            Yii::$app->session->setFlash('info','关注成功。');
        $this->redirect(['sublist']);



    }


    /**
     * Ajax 请求关注
     */
    public function actionAjaxAttention(){
        if (Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;

            //判断是否是登录用户
            if (Yii::$app->user->isGuest){
                return ['errcode'=>1, 'message'=>'请先登录，再进行此操作。'];
            }

            //获取专题id 用户id
            $sid = Yii::$app->request->get('sid');
            $uid = Yii::$app->user->getId();

            //验证是否存在
            if(Attention::isExists($sid, $uid)){
                return ['errcode'=>1, 'message'=>'您已经关注该专题，请不要重复操作。'];
            }

            //保存数据
            $attention = new Attention();
            $attention->subject_id = $sid;
            $attention->user_id = $uid;

            if($attention->save())
                return ['errcode'=>0, 'message'=>'关注成功。'];
            return ['errcode'=>1, 'message'=>'关注失败，请重试。'];


        }
        return false;
    }


}
