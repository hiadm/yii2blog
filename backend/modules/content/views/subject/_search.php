<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SearchSubject */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subject-search pull-right">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class'=>'form-inline'],
        'fieldConfig' => [
                'template' => '{input}'
        ]
    ]); ?>

    <?php //$form->field($model, 'id') ?>

    <?= $form->field($model, 'name')->textInput(['placeholder'=>'专题名']) ?>

    <?php //$form->field($model, 'desc') ?>

    <?php //$form->field($model, 'logo') ?>

    <?= $form->field($model, 'type')->dropDownList([
            '0' => '公开',
            '1' => '会员',
            '2' => '私密'
    ],['prompt'=>'搜索类型']) ?>

    <?= $form->field($model, 'status')->dropDownList([
        '0' => '连载中',
        '1' => '已完结',
    ],['prompt'=>'搜索状态']) ?>

    <?php // echo $form->field($model, 'notice_id') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
