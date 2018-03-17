<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index box box-primary">
    <div class="box-header with-border">
        <?php Html::a('创建用户', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
        <?= Html::a('添加新用户', ['signup'], ['class' => 'pull-left btn btn-success btn-flat']) ?>
        <?= $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'username',
                'email:email',
                // 'status',
                'isvip',
                // 'created_at',
                // 'updated_at',

                [
                    "class" => "yii\grid\ActionColumn",
                    "template" => "{assign} {view} {update} {delete}",
                    "header" => "操作",
                    "buttons" => [
                        "assign" => function ($url, $model, $key) {
                            return Html::a("<i class='glyphicon glyphicon-user'></i>", ['/admin/assignment/view','id'=>$key], ["title" => "指派角色"] );
                        },
                    ],

                ],
            ],
        ]); ?>
    </div>
</div>
<!--http://www.dev.com/admin/index.php?r=admin%2Fassignment%2Findex-->
<!--http://www.dev.com/admin/index.php?r=member%2Fassignment%2Fview&id=1-->
