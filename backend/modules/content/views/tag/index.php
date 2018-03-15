<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SearchTag */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '标签列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('创建标签', ['create'], ['class' => 'btn btn-success btn-flat pull-left']) ?>
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
                [
                    'attribute' => 'subject_id',
                    'value'=>function($model){
                        return $model->subject->name;
                    }
                ],
                'created_by',
                'created_at:date',
                // 'updated_at',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
