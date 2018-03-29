<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Friend */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '友链列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="friend-view box box-primary">
    <div class="box-header">
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => '您确定要删除该项吗?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                'url:url',
                'sort',
            ],
        ]) ?>
    </div>
</div>
