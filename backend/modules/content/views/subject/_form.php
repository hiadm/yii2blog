<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Subject */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subject-form box box-primary">
    <?php $form = ActiveForm::begin([
        'options' => [
            'onkeydown'=>"if(event.keyCode==13){return false;}"
        ],
    ]); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'desc')->textarea(['maxlength' => true]) ?>

        <?= $form->field($model, 'logo')->widget('manks\FileInput', [
            'clientOptions' => [
                /*'pick' => [
                    'multiple' => true,
                ],*/
            ]
        ]);  ?>

        <?= $form->field($model, 'type')->radioList([
                '0' => '公开',
                '1' => 'VIP',
                //'2' => '私密',
        ]) ?>

        <?= $form->field($model, 'status')->radioList([
                '0' => '连载中',
                '1' => '已完结'
        ]) ?>

        <?= $form->field($model, 'notice')->textarea() ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
