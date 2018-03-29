<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SearchFriend */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '友链列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="friend-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('创建友链', ['create'], ['class' => 'btn btn-success btn-flat pull-left']) ?>
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
                'name',
                'url:url',
                'sort',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
