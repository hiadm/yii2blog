<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\user */

$this->title = '设置赞助二维码';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">


    <div class="user-form box box-primary">
        <?php $form = ActiveForm::begin(); ?>
        <div class="box-body table-responsive">
            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model, 'sponsor')->widget('manks\FileInput', [
                        'clientOptions' => [
                            /*'pick' => [
                                'multiple' => true,
                            ],*/
                        ]
                    ])->label('赞助码');  ?>
                </div>
            </div>


        </div>
        <div class="box-footer">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success btn-flat']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>


</div>
