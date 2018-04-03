<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Comment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '评论列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-view box box-primary">
    <div class="box-header">
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => '您确定要删除该评论吗?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'user_id',
                'article_id',
                'content:ntext',
                'likes',
                'created_at:datetime',
            ],
        ]) ?>
    </div>
</div>
