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
        <div class="row">
            <div class="cont-left col-md-8">
                <!-- 用户信息 -->
                <div class="subject-info row">
                    <div class="col-xs-3 col-sm-2 test">
                        <a href="javascript:void(0);">
                            <img class="img-responsive img-radius-full" src="<?= !empty($user['photo'])?$user['photo']:$this->params['userPhoto'];?>">
                        </a>
                    </div>
                    <div class="col-xs-9 col-sm-10 font-pretty">
                        <h3 class="subject-title">
                            <?= $user['username']?>
                            <small class="text-success">
                                <?= $user['isvip']? 'VIP用户' : '普通会员' ;?>
                            </small>
                        </h3>
                        <p class="text-muted">
                            注册时间：<?= date('Y-m-d', $user['created_at'])?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="cont-left col-md-8">
                <?php
                $form = ActiveForm::begin([
                    'id' => 'reset-password-form',
                    'options' => ['class' => 'form-horizontal'],
                ]) ?>

                <div class="col-lg-offset-1 col-lg-11">
                    <?= $form->field($model, 'photo')->widget('manks\FileInput', [
                        'clientOptions' => [
                        ]
                    ]);  ?>
                </div>


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