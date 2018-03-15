<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Subject */

$this->title = '更新专题: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '专题列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="subject-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
