<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\Helper;
use mdm\admin\components\Helper as MdmHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SearchArticle */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index box box-primary">
    <div class="box-header with-border">
        <div class="btn-group" role="group" aria-label="...">
        <?php
        if(MdmHelper::checkRoute('create')) {
           echo Html::a('创建文章', ['create'], ['class' => 'btn btn-success btn-flat pull-left']);
        }
        ?>
        <?= Html::a('草稿箱', ['index','isdraft'=>1], ['class' => 'btn btn-info btn-flat pull-left']) ?>
        <?= Html::a('回收站', ['index','isrecycle'=>1], ['class' => 'btn btn-danger btn-flat pull-left']) ?>
        <?= Html::a('全部', ['index'], ['class' => 'btn btn-warning btn-flat pull-left']) ?>
        </div>
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
                [
                        'attribute' => 'title',
                        'value' => function($model){
                            return Helper::truncate_utf8_string($model->title,15);
                        }
                ],
                // 'brief',
                'favorite',
                'collect',
                'visited',
                [
                        'attribute' => 'type',
                        'value' => function($model){
                            $tmp = ['原创','转载','翻译'];
                            return $tmp[$model->type];
                        }
                ],
                // 'isbest',
                // 'isdraft',
                // 'isrecycle',
                [
                    'attribute' => 'subject_id',
                    'value' => function($model){
                        return $model->subject->name;
                    }
                ],
                // 'content_id',
                'created_by',
                'created_at:date',
                // 'updated_at',

                [
                    'class' => 'yii\grid\ActionColumn',
                    //'template' => MdmHelper::filterActionColumn('{view}{update}{delete}'),
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>',$url . '&author_id='.$model->created_by);
                        },
                        /*'delete' => function ($url, $model, $key) {
                            // return the button HTML code
                        }*/
                    ],
                ],
            ],
        ]); ?>
    </div>
</div>
