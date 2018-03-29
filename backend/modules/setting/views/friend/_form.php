<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Friend */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="friend-form box box-primary">
    <?php $form = ActiveForm::begin([
        //'options' => ['class'=>'form-inline'],
    ]); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'sort')->textInput()->hint('请填写一个数字(0 - 255)之间') ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
