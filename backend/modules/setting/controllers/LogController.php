<?php
namespace backend\modules\setting\controllers;
use backend\models\Log;
use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;

class LogController extends Controller
{
    //日志列表
    public function actionIndex(){
        $query = Log::find();
        $dataProvider = new ActiveDataProvider([
            'query'=>$query->orderBy(['log_time'=>SORT_DESC])
        ]);

        return $this->render('index',[
            'dataProvider'=>$dataProvider
        ]);
    }

    public function actionView($id){
        $model = Log::findOne($id);
        if ($model === null)
            throw new NotFoundHttpException('The requested page does not exist.');

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    //日志清空
    public function actionClear(){
        Log::deleteAll();
        Yii::$app->session->setFlash('删除日志成功。');

        $this->redirect(['index']);
    }
}