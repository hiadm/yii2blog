<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile('static/home/css/subject.css',['depends'=>'frontend\assets\HomeAsset']);
$this->registerCssFile('static/home/css/center.css',['depends'=>'frontend\assets\HomeAsset']);
$this->title = $this->params['siteInfo']['name'] . ' 个人中心';
?>
<!-- 主体 -->
<section class="content">
    <div class="container">
        <?= $this->render('userbar', [
            'user' => $user
        ]) ?>
        <hr>
        <div class="row">
            <div class="cont-left col-md-8">
                <?php
                $form = ActiveForm::begin([
                'id' => 'reset-password-form',
                'options' => ['class' => 'form-horizontal'],
                ]) ?>
                <?= $form->field($model, 'password',[
                        'template' => '<div class="form-group">{label}<div class="col-sm-8">{input}{error}</div></div>',
                ])->passwordInput()->label('原密码',['class'=>'col-sm-2 control-label']) ?>

                <?= $form->field($model, 'new_password',[
                    'template' => '<div class="form-group">{label}<div class="col-sm-8">{input}{error}</div></div>',
                ])->passwordInput()->label('新密码',['class'=>'col-sm-2 control-label']) ?>

                <?= $form->field($model, 're_new_password',[
                    'template' => '<div class="form-group">{label}<div class="col-sm-8">{input}{error}</div></div>',
                ])->passwordInput()->label('重复密码',['class'=>'col-sm-2 control-label']) ?>

                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-11">
                        <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
                <?php ActiveForm::end() ?>
            </div>


            <?= $this->render('sidebar', [

            ]) ?>
        </div>
    </div>
</section>