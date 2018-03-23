<?php
namespace frontend\modules\content\controllers;
use frontend\controllers\BaseController;
use frontend\models\Article;
use frontend\models\Subject;
use yii\helpers\Html;
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


        return $this->render('sublist',[
            'type' => $type,
            'subjects' => $data['subjects'],
            'pagination' => $data['pagination']
        ]);
    }

    /**
     * 专题主页
     */
    public function actionView(){
        $id = (int)Yii::$app->request->get('id');
        if ($id <= 0)
            throw new BadRequestHttpException('请求参数错误.');

        //获取类型
        $type = Yii::$app->request->get('type');
        if (!isset($type))
            $type = 'new';


        //获取专题信息
        $subject = Subject::getDetail($id);

        if (!$subject)
            throw new NotFoundHttpException('没有相关数据。');

        //获取文章数据
        $articlesData = Article::getSubjectArticles($id, $type);



        return $this->render('view',[
            'subject' => $subject,
            'articles' => $articlesData['articles'],
            'pagination' => $articlesData['pagination']
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
            return ['errcode'=>0, 'data'=>$subjects];
        }
        return false;

    }


}
