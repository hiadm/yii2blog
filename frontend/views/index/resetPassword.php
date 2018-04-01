<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $this->params['siteInfo']['name'] .' - '. '重置密码';
?>

<section class="signup">
    <div class="container-fliud">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <div class="wrap">
                    <div class="core">
                        <h4 class="title text-center">
                            <?= Html::encode($this->title) ?>
                        </h4>
                        <div class="inputs">

                            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                            <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

                            <div class="form-group">
                                <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>


</section>

