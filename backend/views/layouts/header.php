<?php
use yii\helpers\Html;


/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="javascript:;">
                        <img src="/<?= empty(Yii::$app->user->identity->photo)? Yii::$app->params['userPhoto'] : Yii::$app->user->identity->photo;?>" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?= \Yii::$app->user->identity->username?></span>
                    </a>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <?= Html::a(
                        '<i class="glyphicon glyphicon-log-out"></i>',
                        ['/site/logout'],
                        ['data-method' => 'post']
                    ) ?>
                </li>
            </ul>
        </div>
    </nav>
</header>
