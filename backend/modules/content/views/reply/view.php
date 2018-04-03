<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Reply */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '回复列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reply-view box box-primary">
    <div class="box-header">
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => '您确定要删除该回复吗?',
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
                'comment_id',
                'content:ntext',
                'created_at:datetime',
            ],
        ]) ?>
    </div>
</div>
