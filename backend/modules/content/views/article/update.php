<?php

use yii\helpers\Html;
use common\components\Helper;

/* @var $this yii\web\View */
/* @var $model backend\models\Article */

$this->title = '更新文章: ' . Helper::truncate_utf8_string($model->title,15);
$this->params['breadcrumbs'][] = ['label' => '文章列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="article-update">

    <?= $this->render('_form', [
        'model' => $model,
        'curSubject' => $curSubject,
        'curTags' => $curTags
    ]) ?>

</div>
