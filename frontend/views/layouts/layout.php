<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
//use yii\widgets\Breadcrumbs;
//use common\widgets\Alert;
use frontend\assets\LayerAsset;
use frontend\assets\HomeAsset;
use yii\helpers\Url;

LayerAsset::register($this);
HomeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

</head>
<body>
<?php $this->beginBody() ?>
<!-- 导航 -->
<header class="header">
    <nav class="navbar navbar-default navbar-fixed-top">

        <div class="container-fluid">
            <div class="pull-left logo">
                <a href="/">
<!--                    <img class="logo" alt="daimajie.com" src="static/home/img/logo.png">-->
                        <?= $this->params['siteInfo']['name']?>
                </a>
            </div>
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active">
                            <a href="/">首页 <span class="sr-only">(current)</span></a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">微信公众号</a>
                        </li>
                    </ul>
                    <form class="search navbar-form navbar-left">
                        <input type="search" placeholder="搜索...">
                    </form>


                    <ul class="nav navbar-nav navbar-right">
                        <?php if(Yii::$app->user->isGuest):?>
                        <li>
                            <a href="<?= Url::to(Yii::$app->user->loginUrl)?>">登陆</a>
                        </li>
                        <li>
                            <a href="<?= Url::to(['/index/signup'])?>">用户注册</a>
                        </li>
                        <?php else:?>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= Yii::$app->user->identity->username?> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?= Url::to(['/user/center/index'])?>">个人中心</a></li>
                                <li><a href="#">写文章</a></li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <?= Html::a(
                                        '安全退出&nbsp;<i class="glyphicon glyphicon-log-out"></i>',
                                        ['/index/logout'],
                                        ['data-method' => 'post']
                                    ) ?>
                                </li>
                            </ul>
                        </li>
                        <?php endif;?>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div>
        </div><!-- /.container-fluid -->

    </nav>
</header>

<?= $content?>

<!-- 页脚 -->
<!-- <footer id="footer"></footer> -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-2">
                <h6>Copyright &copy;<?= Html::encode($this->params['siteInfo']['name'])?></h6>
                <?= '2015-'.date('Y') ?>
            </div>

            <div class="col-sm-4">
                <h6>关于我们</h6>
                <p>
                    <?= $this->params['siteInfo']['about']?>
                </p>
            </div>

            <div class="col-sm-2">
                <h6>导航</h6>
                <ul class="unstyled">
                    <?php foreach ($this->params['siteInfo']['fastchannel'] as $channel):?>
                    <li><a href="<?= $channel['url']?>"><?= $channel['name']?></a></li>
                    <?php endforeach;?>
                </ul>
            </div>

            <div class="col-sm-2">
                <h6>Follow us</h6>
                <ul class="unstyled">
                    <?php foreach ($this->params['siteInfo']['followme'] as $follow):?>
                        <li><a href="$follow['url']?>"><?= $follow['name']?></a></li>
                    <?php endforeach;?>
                </ul>
            </div>

            <div class="col-sm-2">
                <h6><?= Yii::powered() ?> <br/></h6>

            </div>
        </div>
    </div>
</footer><!--页脚结束-->


<?php $this->endBody() ?>
<script>
<?= Yii::$app->session->hasFlash('info')?"layer.msg('".Yii::$app->session->getFlash('info')."');":'';?>
</script>
</body>
</html>
<?php $this->endPage() ?>

