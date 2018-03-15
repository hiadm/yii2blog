<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SearchTag */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tag-search form-inline pull-right">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'fieldConfig' => [
                'template' => '{input}'
        ]
    ]); ?>



    <?= $form->field($model, 'subject')->textInput(['placeholder'=>'专题名']) ?>




    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default  btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
