<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SearchComment */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '评论列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index box box-primary">
    <div class="box-header with-border">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'user_id',
                'article_id',
                'content:ntext',
                'likes',
                // 'created_at',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {delete}'
                ],
            ],
        ]); ?>
    </div>
</div>
