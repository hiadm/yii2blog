<?php
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;

$this->title = '日志列表';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="tag-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('清空日志', ['clear'], [
            'class' => 'btn btn-danger btn-flat pull-left',
            'data' => [
                'confirm' => '您确定要删除所有日志吗?',
            ],
        ]) ?>
        <p class="help-block text-danger">建议七天清空日志信息.</p>
    </div>
    <div class="box-body table-responsive no-padding col-lg-12">
        <?= GridView::widget([
            'dataProvider'=>$dataProvider,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns'=>[
                [
                    'label'=>'编号',
                    //'headerOptions'=>['width'=>'60'],
                    'attribute'=>'id',
                ],
                [
                    'label'=>'级别',
                    //'headerOptions'=>['width'=>'60'],
                    'attribute'=>'level',
                ],
                [
                    'label'=>'分类',
                    //'headerOptions'=>['width'=>'100'],
                    'attribute'=>'category',
                ],
                [
                    'label'=>'记录时间',
                    //'headerOptions'=>['width'=>'100'],
                    'attribute'=>'log_time',
                    'value'=>function($model){
                        return date('Y-m-d H:i:s',$model->log_time);
                    }
                ],
                /*[
                    'label'=>'内容',
                    'format'=>'html',
                    'value'=>function($model){
                        return nl2br($model->message);
                    }
                ],*/
                [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}'
                ],
            ],
        ]);?>

    </div>
</div>

