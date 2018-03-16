<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SearchArticle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-search btn-flat pull-right">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
                'class' => 'form-inline',

        ],
        'fieldConfig' => [
                'template' => '{input}'
        ]
    ]); ?>

    <?php // $form->field($model, 'id') ?>

    <?php // $form->field($model, 'title') ?>

    <?php // $form->field($model, 'brief') ?>

    <?php // $form->field($model, 'smallimg') ?>

    <?php // $form->field($model, 'bigimg') ?>

    <?php // echo $form->field($model, 'favorite') ?>

    <?php // echo $form->field($model, 'collect') ?>

    <?php // echo $form->field($model, 'visited') ?>

    <?php echo $form->field($model, 'type')->dropDownList(
            [
                    '0' => '原创',
                    '1' => '转载',
                    '2' => '翻译',
            ],
            ['prompt'=>'选择类型']
    ) ?>
    <?php echo $form->field($model, 'isbest')->dropDownList(
        [
            '0' => '普通文章',
            '1' => '精品推荐',
        ],
        ['prompt'=>'是否优选']
    ) ?>
    <?php // echo $form->field($model, 'isbest') ?>

    <?php // echo $form->field($model, 'isdraft') ?>

    <?php // echo $form->field($model, 'isrecycle') ?>

    <?php echo $form->field($model, 'subject')->textInput(['placeholder'=>'选择专题']) ?>

    <?php // echo $form->field($model, 'content_id') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
