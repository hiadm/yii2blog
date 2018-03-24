<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\components\Helper;
use yii\widgets\LinkPager;


$this->registerCssFile('static/home/css/subject.css',['depends'=>'frontend\assets\HomeAsset']);
?>

<!-- 主体 -->
<section class="content">
    <div class="container">
        <div class="row">
            <div class="cont-left col-md-8">

                <!-- 专题信息 -->
                <div class="subject-info row">
                    <div class="col-xs-3 col-sm-2 test">
                        <a href="#">
                            <img class="img-responsive img-radius-5" src="<?= $subject['logo']?>">
                        </a>
                    </div>
                    <div class="col-xs-9 col-sm-10 font-pretty">
                        <h3 class="subject-title">
                            <?= $subject['name']?>
                            <small id="is_attend">
                                <?php if(isset($attend) && $attend==true):?>
                                    <a href="javascript:void(0);">已关注</a>
                                <?php else:?>
                                    <a data-id="<?= $subject['id']?>" id="attention_btn" href="javascript:void(0);">点击关注</a>
                                <?php endif;?>
                            </small>
                        </h3>
                        <span class="text-muted">
                            收录了<?= $subject['total']?>篇文章 .
                            <?= $attentionNum?>个关注 .
                            <?= $subject['status']==0?'连载中...':'完结'?> .
                        </span>
                    </div>

                </div>

                <!-- 专题选项卡 -->
                <div class="subject-tab">
                    <div>

                    <!-- Nav tabs -->
                    <ul class="font-pretty font-size-12"">
                        <li class="">
                            <?= Html::a('<span class="glyphicon glyphicon-fire"></span> 最新发布', ['', 'type' => 'new','id'=>$subject['id']]) ?>
                        </li>
                        <li class="">
                            <?= Html::a('<span class="glyphicon glyphicon-send"></span> Hot', ['', 'type' => 'hot','id'=>$subject['id']]) ?>
                        </li>
                        <li class="">
                            <?= Html::a('<span class="glyphicon glyphicon-ok"></span> 精品文章', ['', 'type' => 'best','id'=>$subject['id']]) ?>
                        </li>
                    </ul>
                    </div>
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
                                        <a class="title" href="<?= Url::to(['article/view','id'=>$article['id']])?>"><?= Html::encode($article['title'])?></a>
                                        <p><?= Helper::truncate_utf8_string(Html::encode($article['brief']),88)?></p>
                                    </div>
                                    <div class="brief-right col-sm-3 hidden-xs"><img class="img-responsive" src="<?= $article['smallimg']?>"></div>
                                </div>
                                <div class="params">
                                    <a class="subject-tag" href="#"><?= $subject['name']?></a>
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
                                        <a class="title" href="<?= Url::to(['article/view','id'=>$article['id']])?>"><?= Html::encode($article['title'])?></a>
                                        <p><?= Helper::truncate_utf8_string(Html::encode($article['brief']),88)?></p>
                                    </div>
                                </div>
                                <div class="params">
                                    <a class="subject-tag" href="#"><?= $subject['name']?></a>
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
                <div class="notice font-pretty">
                    <h4 class="text-muted">专题公告</h4>
                    <p>
                    <?= $subject['notice']?>
                    </p>
                </div>
                <hr>

            </div>
        </div>
    </div>
</section>

<?php
$ajaxAttention = Url::to(['ajax-attention']);
$js = <<<JS
    //点击关注按钮
    $('#attention_btn').on('click', function(){
        var sid = $(this).data('id');
        $.get("{$ajaxAttention}", { sid: sid },
          function(data){
            if (data.errcode === 0){
                //关注成功
                $('#is_attend').html('<a href="javascript:void(0);">已关注</a>');
                
            }
            //关注失败
            layer.msg(data.message);
            
        });
    });
JS;


$this->registerJs($js);
?>
