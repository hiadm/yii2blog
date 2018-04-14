<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use common\components\Helper;
use yii\helpers\Html;


$this->registerCssFile('static/home/css/index.css',['depends'=>'frontend\assets\HomeAsset']);
$this->title = $this->params['siteInfo']['name'];
?>

<!-- 主体 -->
<section class="content">
    <div class="container">
        <div class="row">
            <div class="cont-left col-md-8">

                <!-- 文章列表 -->
                <div class="articles">
                    <ul>

                        <?php
                        if(!empty($articles)):
                            foreach($articles as $article):
                                ?>
                                <?php if(!empty($article['smallimg'])):?>
                                <li class="items">
                                    <div class="author">
                                        <a class="pull-left" href="javascript:void(0);">
                                            <img class="img-responsive" src="/<?= !empty($article['user']['photo'])?$article['user']['photo']:$this->params['userPhoto'];?>">
                                        </a>
                                        <div class="info pull-left">
                                            <a href="javascript:void(0);"><?= $article['user']['username']?></a>
                                            <span><?= Yii::$app->formatter->asRelativeTime($article['created_at'])?></span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="brief row">
                                        <div class="brief-left col-sm-9 col-xs-12">
                                            <a class="title" href="<?= Url::to(['/content/article/view','id'=>$article['id']])?>"><?= Helper::truncate_utf8_string(Html::encode($article['title']),22)?></a>
                                            <p><?= Helper::truncate_utf8_string(Html::encode($article['brief']),80)?></p>
                                        </div>
                                        <div class="brief-right col-sm-3 hidden-xs"><img class="img-responsive" src="/<?= $article['smallimg']?>"></div>
                                    </div>
                                    <div class="params">
                                        <a class="subject-tag" href="<?= Url::to(['/content/subject/view',"id"=>$article['subject']['id']])?>"><?= $article['subject']['name']?></a>
                                        <a href="javascript:void(0);">
                                            <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                            <?= $article['visited']?>
                                        </a>
                                        <a href="javascript:void(0);">
                                            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                            <?= $article['collect']?>
                                        </a>
                                        <a href="javascript:void(0);">
                                            <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
                                            <?= $article['favorite']?>
                                        </a>
                                    </div>
                                </li>
                            <?php else:?>
                                <li class="items">
                                    <div class="author">
                                        <a class="pull-left" href="javascript:void(0);">
                                            <img class="img-responsive" src="/<?= !empty($article['user']['photo'])?$article['user']['photo']:$this->params['userPhoto'];?>">
                                        </a>
                                        <div class="info pull-left">
                                            <a href="javascript:void(0);"><?= $article['user']['username']?></a>
                                            <span><?= Yii::$app->formatter->asRelativeTime($article['created_at'])?></span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="brief row">
                                        <div class="brief-left col-xs-12">
                                            <a class="title" href="<?= Url::to(['/content/article/view','id'=>$article['id']])?>"><?= Helper::truncate_utf8_string(Html::encode($article['title']),22)?></a>
                                            <p><?= Helper::truncate_utf8_string(Html::encode($article['brief']),80)?></p>
                                        </div>
                                    </div>
                                    <div class="params">
                                        <a class="subject-tag" href="<?= Url::to(['/content/subject/view',"id"=>$article['subject']['id']])?>"><?= $article['subject']['name']?></a>
                                        <a href="javascript:void(0);">
                                            <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                            <?= $article['visited']?>
                                        </a>
                                        <a href="javascript:void(0);">
                                            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                            <?= $article['collect']?>
                                        </a>
                                        <a href="javascript:void(0);">
                                            <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
                                            <?= $article['favorite']?>
                                        </a>
                                    </div>
                                </li>
                            <?php endif;?>
                            <?php
                            endforeach;
                        endif;
                        ?>
                        <?php if(empty($articles)) echo '暂无文章';?>

                    </ul>


                </div>
                <nav aria-label="">
                    <?=
                    LinkPager::widget([
                        'pagination' => $pagination,
                        'nextPageLabel' => '下一页',
                        'prevPageLabel' => '上一页',
                        'options' => ['class' => 'pagination'],
                    ]);
                    ?>
                </nav>
            </div>


            <div class="cont-right col-md-4">
            </div>
        </div>
    </div>
</section>




