<?php

namespace backend\modules\content\controllers;

use backend\models\Subject;
use backend\models\Tag;
use Yii;
use backend\models\Article;
use backend\models\SearchArticle;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use common\components\Upload as NewUpload;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchArticle();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();

        if ($model->load(Yii::$app->request->post()) && $model->store()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            //获取选中专题
            $curSubject = [];
            $curTags = [];
            if(!empty($model->subject_id)){
                $curSubject = Subject::find()
                    ->select(['name','id'])
                    ->where(['id'=>$model->subject_id])
                    ->indexBy('id')
                    ->asArray()
                    ->column();

                //获取可用标签
                $curTags = Tag::find()
                    ->select(['name','id'])
                    ->where(['subject_id'=>$model->subject_id])
                    ->indexBy('id')
                    ->orderBy(['id'=>SORT_DESC])
                    ->asArray()
                    ->column();
            }


            return $this->render('create', [
                'model' => $model,
                'curSubject' => $curSubject,
                'curTags' => $curTags
            ]);
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        if ($model->load(Yii::$app->request->post()) && $model->renew()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            //获取当前文章 关联的内容及标签ids
            $model->getRelateDate();


            //获取选中专题 及标签列表
            $curSubject = [];
            $curTags = [];
            if(!empty($model->subject_id)){
                $curSubject = Subject::find()
                    ->select(['name','id'])
                    ->where(['id'=>$model->subject_id])
                    ->indexBy('id')
                    ->asArray()
                    ->column();

                //获取可用标签
                $curTags = Tag::find()
                    ->select(['name','id'])
                    ->where(['subject_id'=>$model->subject_id])
                    ->indexBy('id')
                    ->orderBy(['id'=>SORT_DESC])
                    ->asArray()
                    ->column();
            }


            return $this->render('update', [
                'model' => $model,
                'curSubject' => $curSubject,
                'curTags' => $curTags
            ]);
        }
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model->discard()){
            Yii::$app->session->setFlash('info', '删除文章成功。');
        }else
            Yii::$app->session->setFlash('info', '删除文章失败。');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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


    //编辑器上传图片
    public function actionEditUpload(){
        if (Yii::$app->request->isPost){
            Yii::$app->response->format = Response::FORMAT_JSON;

            $model = new NewUpload();
            $info = $model->upImage();
            if ($info && is_array($info)) {
                return ['code' => 0, 'data' => [
                    'src' => $info['url']
                ]];
            } else {
                return ['code' => 1, 'msg' => '上传失败'];
            }


        }
        throw new MethodNotAllowedHttpException('请求方式不被允许。');
    }
}
