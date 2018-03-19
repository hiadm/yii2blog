<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Seo */

$this->title = '设置 SEO';
$this->params['breadcrumbs'][] = '设置 SEO';
?>
<div class="seo-update">

    <div class="seo-form box box-primary">
        <?php $form = ActiveForm::begin(); ?>
        <div class="box-body table-responsive">
            <div class="col-lg-6">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'keyword')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'fastchannel')->textInput(['maxlength' => true,'placeholder'=>'专题1，专题2，专题3'])?>
                <p class="text-danger">多的专题用逗号分开（如：专题1，专题2，专题3）最多选5个专题</p>
            </div>

        </div>
        <div class="box-footer">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success btn-flat']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>

