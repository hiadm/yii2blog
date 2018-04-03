<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SearchReply */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reply-search pull-right">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class'=>'form-inline'],
        'fieldConfig' => [
            'template' => '{input}'
        ]
    ]); ?>


    <?= $form->field($model, 'user_id')->textInput(['placeholder'=>'用户id']) ?>

    <?= $form->field($model, 'article_id')->textInput(['placeholder'=>'文章id']) ?>

    <?= $form->field($model, 'comment_id')->textInput(['placeholder'=>'评论id']) ?>


    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
