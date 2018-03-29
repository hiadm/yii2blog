<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SearchFriend */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="friend-search pull-right">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class'=>'form-inline'],
        'fieldConfig' => [
            'template' => '{input}'
        ]
    ]); ?>

    <?php // $form->field($model, 'id') ?>

    <?= $form->field($model, 'name')->textInput(['placeholder'=>'名称']) ?>

    <?php // $form->field($model, 'url') ?>

    <?php // $form->field($model, 'sort') ?>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
