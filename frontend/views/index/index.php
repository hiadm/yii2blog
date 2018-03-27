<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use common\components\Helper;
use yii\helpers\Html;


$this->registerCssFile('static/home/css/index.css',['depends'=>'frontend\assets\HomeAsset']);
?>

<!-- 主体 -->
<section class="content">
    <div class="container">
        <div class="row">
            <div class="cont-left col-md-8">
                <!-- 轮播图 -->
                <?php if (!empty($bestArticle)):?>
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <?php for($i=0; $i<count($bestArticle); ++$i):?>
                        <li data-target="#carousel-example-generic" data-slide-to="<?= $i?>" class="active"></li>
                        <?php endfor;?>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <?php foreach($bestArticle as $key=>$item):?>
                        <div class="item <?= $key?'':'active'?>" style="max-height: 263px;">
                            <img src="<?= $item['bigimg']?>" alt="<?= $item['title']?>" >
                            <div class="carousel-caption">
                                <?= $item['title']?>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <?php endif;?>

                <!-- 专题 -->
                <div class="subject">
                    <ul>
                        <?php
                        if(!empty($subjects)):
                            foreach($subjects as $item):
                            ?>
                                <li class="subjects">
                                    <a href="<?= Url::to(['/content/subject/view', 'id'=>$item['id']]);?>">
                                        <img src="<?= $item['logo']?>">
                                        <span><?= $item['name']?></span>

                                    </a>
                                </li>
                            <?php
                            endforeach;
                        endif;
                        if(empty($subjects))
                            echo '暂无专题';
                        ?>

                        <li>
                            <a href="<?= Url::to(['/content/subject/sublist'])?>">
                                <span>更多热门专题 <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></span>
                            </a>
                        </li>
                    </ul>
                </div>

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
                                <a class="pull-left" href="javascript:;">
                                    <img class="img-responsive" src="<?= !empty($article['user']['photo'])?$article['user']['photo']:$this->params['userPhoto'];?>">
                                </a>
                                <div class="info pull-left">
                                    <a href="javascript:;"><?= $article['user']['username']?></a>
                                    <span><?= Yii::$app->formatter->asRelativeTime($article['created_at'])?></span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="brief row">
                                <div class="brief-left col-sm-9 col-xs-12">
                                    <a class="title" href="<?= Url::to(['/content/article/view','id'=>$article['id']])?>"><?= Html::encode($article['title'])?></a>
                                    <p><?= Helper::truncate_utf8_string(Html::encode($article['brief']),88)?></p>
                                </div>
                                <div class="brief-right col-sm-3 hidden-xs"><img class="img-responsive" src="<?= $article['smallimg']?>"></div>
                            </div>
                            <div class="params">
                                <a class="subject-tag" href="#"><?= $article['subject']['name']?></a>
                                <a href="#">
                                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                    <?= $article['visited']?>
                                </a>
                                <a href="#">
                                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                    <?= $article['collect']?>
                                </a>
                                <a href="#">
                                    <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
                                    <?= $article['favorite']?>
                                </a>
                            </div>
                        </li>
                        <?php else:?>
                        <li class="items">
                            <div class="author">
                                <a class="pull-left" href="javascript:;">
                                    <img class="img-responsive" src="<?= !empty($article['user']['photo'])?$article['user']['photo']:$this->params['userPhoto'];?>">
                                </a>
                                <div class="info pull-left">
                                    <a href="javascript:;"><?= $article['user']['username']?></a>
                                    <span><?= Yii::$app->formatter->asRelativeTime($article['created_at'])?></span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="brief row">
                                <div class="brief-left col-xs-12">
                                    <a class="title" href="<?= Url::to(['/content/article/view','id'=>$article['id']])?>"><?= Html::encode($article['title'])?></a>
                                    <p><?= Helper::truncate_utf8_string(Html::encode($article['brief']),88)?></p>
                                </div>
                            </div>
                            <div class="params">
                                <a class="subject-tag" href="#"><?= $article['subject']['name']?></a>
                                <a href="#">
                                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                    <?= $article['visited']?>
                                </a>
                                <a href="#">
                                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                    <?= $article['collect']?>
                                </a>
                                <a href="#">
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


            <div class="cont-right col-md-4 hidden-xs hidden-sm">
                <!-- 快速导航 -->
                <div class="Ranking">
                    <a href="#"><img width="100%" src="static/home/img/bar1.png"></a>
                    <a href="#"><img width="100%" src="static/home/img/bar2.png"></a>
                    <a href="#"><img width="100%" src="static/home/img/bar3.png"></a>
                    <a href="#"><img width="100%" src="static/home/img/bar4.png"></a>
                    <a href="#"><img width="100%" src="static/home/img/bar5.png"></a>
                </div>

                <!-- 二维码 -->
                <hr>
                <div class="media">
                    <div class="media-left media-middle">
                        <a href="#">
                            <img width="64px" class="media-object" src="static/home/img/code.png" alt="...">
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">不妨先来看看</h4>
                        徽章是一个修饰性的元素，它们本身细小而并不显眼，但掺杂在其它元素中就显得尤为突出了。
                    </div>
                </div>

                <!-- 友链 -->
                <hr>
                <div class="friend-link fly-panel fly-link">
                    <h4 class="dl_common_t">友情链接</h4>
                    <dl>
                        <dd>
                            <a href="http://www.layui.com/" target="_blank">layui</a>
                        </dd>
                        <dd>
                            <a href="http://layim.layui.com/" target="_blank">LayIM</a>
                        </dd>
                        <dd>
                            <a href="http://layer.layui.com/" target="_blank">layer</a>
                        </dd>
                        <dd>
                            <a href="http://www.layui.com/" target="_blank">layui</a>
                        </dd>
                        <dd>
                            <a href="http://layim.layui.com/" target="_blank">LayIM</a>
                        </dd>
                        <dd>
                            <a href="http://layer.layui.com/" target="_blank">layer</a>
                        </dd>
                        <dd>
                            <a href="http://www.layui.com/" target="_blank">layui</a>
                        </dd>
                        <dd>
                            <a href="http://layim.layui.com/" target="_blank">LayIM</a>
                        </dd>
                        <dd>
                            <a href="http://layer.layui.com/" target="_blank">layer</a>
                        </dd>
                    </dl>
                </div>





            </div>
        </div>
    </div>
</section>


