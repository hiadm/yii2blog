<?php

namespace backend\modules\content\controllers;

use backend\models\Notice;
use Yii;
use backend\models\Subject;
use backend\models\SearchSubject;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use common\components\Upload as NewUpload;


/**
 * SubjectController implements the CRUD actions for Subject model.
 */
class SubjectController extends Controller
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
     * Lists all Subject models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchSubject();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Subject model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        //获取对应专题
        $model->notice = Notice::findOne($model->notice_id)->notice;

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Subject model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Subject();

        if ($model->load(Yii::$app->request->post()) && $model->store()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Subject model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //获取对应专题
        $model->notice = Notice::findOne($model->notice_id)->notice;

        if ($model->load(Yii::$app->request->post()) && $model->renew()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Subject model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if(empty($model->tags)){
            $model->discard();

        }else{
            Yii::$app->session->setFlash('info', '请先清空该专题的所有标签。');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Subject model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Subject the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subject::findOne($id)) !== null) {
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
                $info = $model->upImage();

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
     * ajax请求专题
     */
    public function actionAjaxGetSubjects(){
        if (Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;

            //获取请求数据
            $name = Yii::$app->request->post('subject');
            if (empty($name))
                return ['errorno'=>1, 'message'=>'传递参数错误 请重试。'];
            $subjects = Subject::find()
                ->select(['id','name'])
                ->where(['like', 'name', $name])
                ->all();

            if($subjects){
                return ['errorno'=>0, 'data'=>$subjects];
           }
            return ['errorno'=>1, 'message'=>'没有相似专题。'];
        }
    }
}
