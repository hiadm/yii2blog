<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\user */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'username')->textInput([
                'maxlength' => true,
            ]) ?>


        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>


        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>


        <?= $form->field($model, 'isvip')->radioList([
                '0' => '普通会员',
                '1' => 'VIP用户',
        ]) ?>


    </div>
    <div class="box-footer">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
