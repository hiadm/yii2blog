<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Subject */

$this->title = '创建专题';
$this->params['breadcrumbs'][] = ['label' => '专题列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subject-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
