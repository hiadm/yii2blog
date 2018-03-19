<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \common\components\Helper;
use mdm\admin\components\Helper as MdmHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SearchSubject */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '专题列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subject-index box box-primary">
    <div class="box-header with-border">

        <?php
        if(MdmHelper::checkRoute('create')) {
            echo Html::a('创建专题', ['create'], ['class' => 'btn btn-success btn-flat pull-left']);
        }
        ?>
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
                    'attribute' => 'desc',
                    'value' => function($model){
                        return Helper::truncate_utf8_string($model->desc,18);
                    }
                ],
                [
                    'attribute' => 'type',
                    'value' => function($model){
                        $tmp = ['公开','会员','私密'];
                        return $tmp[$model->type];
                    }
                ],
                [
                    'attribute' => 'status',
                    'value' => function($model){
                        $tmp = ['连载中','已完结'];
                        return $tmp[$model->status];
                    }
                ],
                'created_at:date',


                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => MdmHelper::filterActionColumn('{view}{update}{delete}'),
                ],
            ],
        ]); ?>
    </div>
</div>
