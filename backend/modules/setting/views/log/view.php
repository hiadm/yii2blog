<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Tag */

$this->title = '日志详情';
$this->params['breadcrumbs'][] = ['label' => '日志列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-view box box-primary">
    <div class="box-header">
        <?= Html::a('返回', ['index'], ['class' => 'btn btn-primary btn-flat']) ?>

    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'level',
                'category',
                'log_time',
                'prefix',
                'message'

            ],
        ]) ?>
    </div>
</div>
