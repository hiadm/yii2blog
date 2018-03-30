<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = $this->params['siteInfo']['name'] .' - '. '用户登陆';

?>
<section class="signup">
    <div class="container-fliud">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <div class="wrap">
                    <div class="core">
                        <h4 class="title text-center">
                            <a class="active" href="javascript:void(0);">登录</a>
                            <b>.</b>
                            <a href="<?= Url::to(['/index/signup'])?>">注册</a>
                        </h4>
                        <div class="inputs">

                        <?php
                        $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'fieldConfig' => [
                                'template' => '{label}{input}{error}',
                            ],
                        ])
                        ?>
                            <?= $form->field($model, 'username')->textInput()?>
                            <?= $form->field($model, 'password')->passwordInput()?>



                            <div class="row">
                                <div class="form-group col-md-6">
                                    <?= $form->field($model, 'captcha')->textInput()?>
                                </div>
                                <div class="col-md-6">
                                    <a id="re_captcha">
                                        <img src="<?= Url::to(['index/captcha'])?>" alt="验证码">
                                    </a>
                                </div>
                            </div>

                            <?= $form->field($model, 'rememberMe')->checkbox()?>

                            <?= Html::submitButton('点击登录', ['class' => 'btn btn-success']) ?>
                            <?= Html::a('忘记密码', ['#'], ['class' => 'profile-link pull-right']) ?>
                        <?php ActiveForm::end() ?>

                        </div>
                        <div class="authorize text-center text-muted">
                            <h6>————— 社交账号登陆 —————</h6>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


</section>
<?php
$re_captcha = Yii::$app->urlManager->createAbsoluteUrl(['/index/captcha']);
$js = <<<JS
    
    $('#re_captcha').on('click', function(){
        var url = "{$re_captcha}&" + Math.random();
        $(this).find('img').attr('src', url);
    });
JS;


$this->registerJs($js);
?>
