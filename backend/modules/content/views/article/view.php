<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Helper;
use backend\models\Content;
/* @var $this yii\web\View */
/* @var $model backend\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = Helper::truncate_utf8_string($this->title,15);
?>
<div class="article-view box box-primary">
    <div class="box-header">
        <?php
        //if(MdmHelper::checkRoute('update')) {
            echo Html::a('更新', ['update', 'id' => $model->id,'author_id'=>$model->created_by], ['class' => 'btn btn-primary btn-flat']);

        //}
        ?>
        <?php
        //if(MdmHelper::checkRoute('delete')) {
            echo Html::a('删除', ['delete', 'id' => $model->id,'author_id'=>$model->created_by], [
                'class' => 'btn btn-danger btn-flat',
                'data' => [
                    'confirm' => '您确定要删除该文章吗?',
                    'method' => 'post',
                ],
            ]);
        //}
        ?>
        <?php
        echo Html::a('返回', ['index'],['class' => 'btn btn-success btn-flat']);
        ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'template' => "<tr><th width='120'>{label}</th><td>{value}</td></tr>",
            'model' => $model,
            'attributes' => [
                'id',
                'title',
                'brief',
                'smallimg',
                'bigimg',
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
                [
                    'attribute' => 'isbest',
                    'value' => function($model){
                        $tmp = ['普通文章','精品推荐'];
                        return $tmp[$model->isbest];
                    }
                ],
                [
                        'label'=>'所属专题',
                        'attribute' => 'subject_id',
                        'value' => function($model){
                            return $model->subject->name;
                        }
                ],
                [
                        'label' => '标签',
                        'value' => function($model){
                            $str = '';
                            foreach($model->tags as $tag){
                                $str .= $tag->name . '，';
                            }
                            return trim($str,'，');
                        }
                ],
                'created_by',
                'created_at:datetime',
                'updated_at:datetime',
                [
                        'label' => '内容',
                        'attribute' => 'content',
                        'value' => function($model){
                            return Content::findOne($model->content_id)->content;
                        }
                ]
            ],
        ]) ?>
    </div>
</div>
