<?php

namespace backend\modules\content\controllers;

use http\Env\Response;
use Yii;
use backend\models\Tag;
use backend\models\SearchTag;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TagController implements the CRUD actions for Tag model.
 */
class TagController extends Controller
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
     * Lists all Tag models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchTag();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tag model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        //$model = $this->findModel($id)->
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tag model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tag();

        if ($model->load(Yii::$app->request->post()) && $model->store()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Tag model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            //获取当前专题
            $curSubject = $model->getCurrentSubject();

            return $this->render('update', [
                'model' => $model,
                'curSubject' => $curSubject
            ]);
        }
    }

    /**
     * Deletes an existing Tag model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $id = intval($id);
        if ($id <= 0){
            Yii::$app->session->setFlash('info', '传递参数错误。');
        }

        $model = $this->findModel($id);

        if(!$model->canDelete()){
            Yii::$app->session->setFlash('info', '请先删除关联文章。');
        }else{

            if ($model->delete())
                Yii::$app->session->setFlash('info', '删除标签成功。');
            else
                Yii::$app->session->setFlash('info', '删除标签失败。');
        }



        return $this->redirect(['index']);
    }

    /**
     * Finds the Tag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Tag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tag::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * ajax 携带subject id 请求可用标签
     */
    public function actionAjaxGetTags(){
        if (Yii::$app->request->isAjax){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            //获取专题id
            $subject_id = intval(Yii::$app->request->post('subject_id'));
            if ($subject_id <= 0)
                return ['errorno'=>1, 'message'=>'传递参数错误 请重试。'];

            //根据专题id获取所有标签
            $tags = Tag::find()
                ->select(['name', 'id'])
                ->where(['subject_id' => $subject_id])
                ->orderBy(['id'=>SORT_DESC])
                ->all();
            if ($tags)
                return ['errorno'=>0, 'data'=>$tags];

            return ['errorno'=>1, 'message'=>'没有可用标签。'];


        }
        return false;
    }
}
