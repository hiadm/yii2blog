<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SearchUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search pull-right">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
                'class' => 'form-inline'
        ],
        'fieldConfig' => [
                'template' => "{input}"
        ],

    ]); ?>

    <?php // $form->field($model, 'id') ?>

    <?= $form->field($model, 'username')->textInput(['placeholder'=>'用户名']) ?>

    <?php // $form->field($model, 'auth_key') ?>

    <?php // $form->field($model, 'password_hash') ?>

    <?php // $form->field($model, 'password_reset_token') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'isvip') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
