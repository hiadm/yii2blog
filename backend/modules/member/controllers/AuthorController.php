<?php
namespace backend\modules\member\controllers;
use backend\models\User;
use yii\web\Controller;
use Yii;
use common\components\Upload as NewUpload;
use yii\web\Response;
use yii\web\MethodNotAllowedHttpException;
use common\components\Helper;

class AuthorController extends Controller
{
    //作者中心
    public function actionSponsor(){

        $model = User::findOne(Yii::$app->user->getId());

        if (Yii::$app->request->isPost){

            $model->sponsor = trim(Yii::$app->request->post('User')['sponsor']);

            if (!empty($model->sponsor) && strlen($model->sponsor) <= 125){
                //删除原有图片
                Helper::delImage($model->getOldAttribute('sponsor'));


                //剪切图片
                $model->sponsor = Helper::thumbImage($model->sponsor, 280, 280);
                if ($model->sponsor === false)
                    $model->addError('sponsor', '上传图片失败，请重试。');


                if($model->save()){
                    Yii::$app->session->setFlash('success', '设置赞助码成功。');
                }else{
                    Yii::$app->session->setFlash('error', '设置赞助码失败。');
                }
            }


        }


        return $this->render('sponsor',[
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
}