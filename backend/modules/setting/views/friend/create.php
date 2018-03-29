<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Friend */

$this->title = '创建友链';
$this->params['breadcrumbs'][] = ['label' => '友链列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="friend-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
