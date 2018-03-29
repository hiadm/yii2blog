<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Friend */

$this->title = '更新友链: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '友链列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="friend-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
