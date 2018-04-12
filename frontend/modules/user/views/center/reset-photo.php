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