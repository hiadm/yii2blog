<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use mdm\admin\components\Helper as MdmHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Tag */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '标签列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-view box box-primary">
    <div class="box-header">
        <?php
        if(MdmHelper::checkRoute('update')) {
            echo Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']);

        }
        ?>
        <?php
        if(MdmHelper::checkRoute('delete')) {
            echo Html::a('删除', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-flat',
                'data' => [
                    'confirm' => '您确定要删除该标签吗?',
                    'method' => 'post',
                ],
            ]);
        }
        ?>
        <?php
        echo Html::a('返回', ['index'],['class' => 'btn btn-success btn-flat']);
        ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                [
                    'attribute' => 'subject_id',
                    'value'=>function($model){
                        return $model->subject->name;
                    }
                ],
                'created_by',
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>
    </div>
</div>
