<?php

namespace backend\modules\setting\controllers;

use Yii;
use backend\models\Seo;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Upload as NewUpload;

/**
 * SeoController implements the CRUD actions for Seo model.
 */
class SeoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

        ];
    }



    /**
     * Updates an existing Seo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = Seo::findOne(1);

        if ($model->load(Yii::$app->request->post()) && $model->store()) {
            Yii::$app->session->setFlash('success', '设置成功。');
        }else{
            Yii::$app->session->setFlash('error', $model->getFirstErrors());
        }

        //获取快速通道 和 关注我
        $quicks = unserialize($model->fastchannel);
        $follows = unserialize($model->followme);


        return $this->render('update', [
            'model' => $model,
            'quicks' => $quicks,
            'follows' => $follows,
        ]);
    }




}
