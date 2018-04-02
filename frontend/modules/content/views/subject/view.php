<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\components\Helper;
use yii\widgets\LinkPager;


$this->registerCssFile('static/home/css/subject.css',['depends'=>'frontend\assets\HomeAsset']);

$this->title = $subject['name'] . ' - ' .$this->params['siteInfo']['name'];
$this->registerMetaTag(array("name"=>"keywords","content"=>"{$subject['name']},{$this->params['siteInfo']['name']}"));
$this->registerMetaTag(array("name"=>"description","content"=>"{$subject['desc']}"));
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
                                    <button class="btn btn-link" data-id="<?= $subject['id']?>" id="attention_btn">点击关注</button>
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
                    <ul class="font-pretty font-size-12">
                        <li class="new <?= empty($_GET['type'])||$_GET['type']=='new'?'active ':'';?>">
                            <?= Html::a('<span class="glyphicon glyphicon-fire"></span> 所有发布', ['', 'type' => 'new','id'=>$subject['id']]) ?>
                        </li>
                        <li class="hot <?= !empty($_GET['type'])&&$_GET['type']=='hot'?'active ':'';?>">
                            <?= Html::a('<span class="glyphicon glyphicon-send"></span> Hot', ['', 'type' => 'hot','id'=>$subject['id']]) ?>
                        </li>
                        <li class="best <?= !empty($_GET['type'])&&$_GET['type']=='best'?'active ':'';?>">
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
                                        <p><?= Helper::truncate_utf8_string(Html::encode($article['brief']),80)?></p>
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
                                        <p><?= Helper::truncate_utf8_string(Html::encode($article['brief']),80)?></p>
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
                        <?php if(empty($articles)) echo "暂无文章";?>
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

                <!-- 云标签 -->
                <hr>
                <div class="cloud-tag">
                    <div class="dl_wrap">
                        <h4 class="dl_common_t text-muted"><span>专题标签</span>
                        </h4>
                        <div class="develop_c">
                            <?php foreach($subject['tags'] as $tag):?>
                            <a href="<?= Url::to(['', 'tid'=>$tag['id'],'id'=>$subject['id']])?>" title="<?= Html::encode($tag['name'])?>" class="tag"><?= Html::encode($tag['name'])?></a>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>



        </div>
    </div>
</section>

<?php
$ajaxAttention = Url::to(['ajax-attention']);
$js = <<<JS
    //点击关注按钮
    $('#attention_btn').on('click', function(){
        $(this).attr('disabled', true);
        
        var sid = $(this).data('id');
        $.get("{$ajaxAttention}", { sid: sid },
          function(data){
            if (data.errcode === 0){
                //关注成功
                $('#is_attend').html('<a href="javascript:void(0);">已关注</a>');
                
            }
            //关注失败
            layer.msg(data.message);
            $(this).attr('disabled', false);
        });
    });


    //标签随机色
    $(function(){
        var tags = $('a.tag');
        allocateColor(tags);
    });
    /*随机分配颜色*/
    function allocateColor(oList){
        oList.each(function(index, el){
            var randColor = changeColor();
            $(this).css({
                'border-color': '#'+randColor,
                'color': '#'+randColor
            });
        });
    }
    /*生成颜色*/
    function changeColor(){
        var r = parseInt(Math.random() * 225);
        var g = parseInt(Math.random() * 225);
        var b = parseInt(Math.random() * 225);
        var colorHex = r.toString(16) + g.toString(16) + b.toString(16);
        return colorHex;
    }
    
    
JS;


$this->registerJs($js);
?>
