<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Tag */

$this->title = '更新标签: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '标签列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="tag-update">

    <?= $this->render('_form', [
        'model' => $model,
        'curSubject' => $curSubject
    ]) ?>

</div>
