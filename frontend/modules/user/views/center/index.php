<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\components\Helper;
use yii\widgets\LinkPager;


$this->registerCssFile('static/home/css/subject.css',['depends'=>'frontend\assets\HomeAsset']);
$this->registerCssFile('static/home/css/center.css',['depends'=>'frontend\assets\HomeAsset']);
$this->title = $this->params['siteInfo']['name'] . ' 个人中心';
?>
<!-- 主体 -->
<section class="content">
    <div class="container">
        <div class="row">
            <div class="cont-left col-md-8">
            <!-- 用户信息 -->
            <div class="subject-info row">
                <div class="col-xs-3 col-sm-2 test">
                    <a href="javascript:void(0);">
                        <img class="img-responsive img-radius-full" src="<?= !empty($user['photo'])?$user['photo']:$this->params['userPhoto'];?>">
                    </a>
                </div>
                <div class="col-xs-9 col-sm-10 font-pretty">
                    <h3 class="subject-title">
                        <?= $user['username']?>
                        <small class="text-success">
                            <?= $user['isvip']? 'VIP用户' : '普通会员' ;?>
                        </small>
                    </h3>
                    <p class="text-muted">
                        注册时间：<?= date('Y-m-d', $user['created_at'])?>
                    </p>
                </div>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="cont-left col-md-8">
                <!-- 专题选项卡 -->
                <div class="subject-tab">
                    <div>
                        <?php $type = !empty($_GET['type'])?$_GET['type']:'collect';?>
                        <!-- Nav tabs -->
                        <ul class="font-pretty font-size-12">
                            <li class="<?= $type == 'collect'?'active':'';?>">
                                <a class="text-muted" href="<?= Url::to(['', 'type'=>'collect'])?>">
                                    <span class="glyphicon glyphicon-leaf" aria-hidden="true"></span>
                                    收藏
                                </a>
                            </li>
                            <li class="<?= $type == 'likes'?'active':'';?>">
                                <a class="text-muted" href="<?= Url::to(['', 'type'=>'likes'])?>">
                                    <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
                                    喜欢
                                </a>
                            </li>
                            <li class="<?= $type == 'attention'?'active':'';?>">
                                <a class="text-muted" href="<?= Url::to(['', 'type'=>'attention'])?>">
                                    <span class="glyphicon glyphicon-fire" aria-hidden="true"></span>
                                    关注
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>

                <!-- 文章列表 -->
                <div class="articles">
                    <ul>
                        <?php if(!empty($articles['data'])):?>
                            <?php foreach($articles['data'] as $article):?>
                                <?php if(!empty($article['article']['smallimg'])):?>
                                    <li class="items">
                                        <div class="author">
                                            <a class="pull-left" href="javascript:void(0);">
                                                <img class="img-responsive" src="<?= empty($article['article']['user']['photo'])?$this->params['userPhoto']:$article['article']['user']['photo'];?>">
                                            </a>
                                            <div class="info pull-left">
                                                <a href="javascript:void(0);"><?= $article['article']['user']['username']?></a>
                                                <span><?= Yii::$app->formatter->asRelativeTime($article['article']['created_at'])?></span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="brief row">
                                            <div class="brief-left col-sm-9 col-xs-12">
                                                <a class="title" href="<?= Url::to(['/content/article/view', 'id'=>$article['article']['id']])?>"><?= Helper::truncate_utf8_string(Html::encode($article['article']['title']),22)?></a>
                                                <p><?= Helper::truncate_utf8_string(Html::encode($article['article']['brief']),80)?></p>
                                            </div>
                                            <div class="brief-right col-sm-3 hidden-xs">
                                                <img class="img-responsive" src="<?= $article['article']['smallimg']?>">
                                            </div>
                                        </div>
                                        <div class="params">
                                            <a class="subject-tag" href="<?= Url::to(['/content/subject/view', 'id'=>$article['article']['subject']['id']])?>"><?= $article['article']['subject']['name']?></a>
                                            <a href="javascript:void(0);">
                                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                                <?= $article['article']['visited']?>
                                            </a>
                                            <a href="javascript:void(0);">
                                                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                                <?= $article['article']['collect']?>
                                            </a>
                                            <a href="javascript:void(0);">
                                                <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
                                                <?= $article['article']['favorite']?>
                                            </a>
                                            <?php if($articles['type'] == 'collect'):?>
                                                <button class="cancel-collect btn btn-link" data-id="<?= $article['article']['id']?>">取消收藏</button>
                                            <?php else:?>
                                                <button class="cancel-likes btn btn-link" data-id="<?= $article['article']['id']?>">取消喜欢</button>
                                            <?php endif;?>


                                        </div>
                                    </li>
                                <?php else:?>
                                    <li class="items">
                                        <div class="author">
                                            <a class="pull-left" href="javascript:void(0);">
                                                <img class="img-responsive" src="<?= empty($article['article']['user']['photo'])?$this->params['userPhoto']:$article['article']['user']['photo'];?>">
                                            </a>
                                            <div class="info pull-left">
                                                <a href="javascript:void(0);"><?= $article['article']['user']['username']?></a>
                                                <span><?= Yii::$app->formatter->asRelativeTime($article['article']['created_at'])?></span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="brief row">
                                            <div class="brief-left col-xs-12">
                                                <a class="title" href="<?= Url::to(['/content/article/view', 'id'=>$article['article']['id']])?>"><?= Helper::truncate_utf8_string(Html::encode($article['article']['title']),22)?></a>
                                                <p><?= Helper::truncate_utf8_string(Html::encode($article['article']['brief']),80)?></p>
                                            </div>
                                        </div>
                                        <div class="params">
                                            <a class="subject-tag" href="<?= Url::to(['/content/subject/view', 'id'=>$article['article']['subject']['id']])?>"><?= $article['article']['subject']['name']?></a>
                                            <a href="javascript:void(0);">
                                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                                <?= $article['article']['visited']?>
                                            </a>
                                            <a href="javascript:void(0);">
                                                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                                <?= $article['article']['collect']?>
                                            </a>
                                            <a href="javascript:void(0);">
                                                <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
                                                <?= $article['article']['favorite']?>
                                            </a>
                                            <?php if($articles['type'] == 'collect'):?>
                                                <button class="cancel-collect btn btn-link" data-id="<?= $article['article']['id']?>">取消收藏</button>
                                            <?php else:?>
                                                <button class="cancel-likes btn btn-link" data-id="<?= $article['article']['id']?>">取消喜欢</button>
                                            <?php endif;?>
                                        </div>
                                    </li>
                                <?php endif;?>
                            <?php endforeach;?>
                        <?php elseif(!empty($subjects['data'])):?>
                            <?php foreach($subjects['data'] as $subject):?>
                                <div class="media">
                                    <div class="media-left media-middle">
                                        <a href="<?= Url::to(['/content/subject/view', 'id'=>$subject['subject']['id']])?>">
                                            <img class="media-object" width="64" height="64" src="<?= $subject['subject']['logo']?>" alt="<?= $subject['subject']['name']?>">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading"><?= $subject['subject']['name']?></h4>
                                        <?= $subject['subject']['desc']?>
                                        <button class="cancel-attention btn btn-link pull-right" data-id="<?= $subject['subject']['id']?>">取消关注</button>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        <?php else:?>
                            <p>暂无数据</p>
                        <?php endif;?>
                    </ul>
                </div>
                <nav aria-label="Page navigation">
                    <?php
                    if(!empty($subjects['data'])){

                        echo LinkPager::widget([
                            'pagination' => $subjects['pagination'],
                        ]);
                    }elseif(!empty($articles['data'])){
                        echo LinkPager::widget([
                            'pagination' => $articles['pagination'],
                        ]);
                    }
                    ?>
                </nav>
            </div>


            <?= $this->render('sidebar', [

            ]) ?>
        </div>
    </div>
</section>

<?php
$cancelCollect = Url::to(['cancel-collect']);
$cancelLikes = Url::to(['cancel-likes']);
$cancelAttention = Url::to(['cancel-attention']);
$js = <<<JS
    //取消收藏
    $('.cancel-collect').on('click', function(){
        $(this).attr('disabled', true);
        
        var aid = $(this).data('id');
        var that = $(this);
        if (typeof aid !== 'number')
            return false;
        
        $.post("{$cancelCollect}","id="+aid, function(d){
            if (d.errcode === '0'){
                //取消关注成功
                that.closest('li.items').remove();
            }
            layer.msg(d.message);
            that.attr('disabled', false);
        });
        
        
    });

    //取消喜欢
    $('.cancel-likes').on('click', function(){
        $(this).attr('disabled', true);
        
        var aid = $(this).data('id');
        
        var that = $(this);
        if (typeof aid !== 'number')
            return false;
        
        $.post("{$cancelLikes}","id="+aid, function(d){
            if (d.errcode === '0'){
                //取消关注成功
                that.closest('li.items').remove();
            }
            layer.msg(d.message);
            that.attr('disabled', false);
        });
        
    });
    
    //取消喜欢
    $('.cancel-attention').on('click', function(){
        $(this).attr('disabled', true);
        
        var aid = $(this).data('id');
        
        var that = $(this);
        if (typeof aid !== 'number')
            return false;
        
        $.post("{$cancelAttention}","id="+aid, function(d){
            if (d.errcode === '0'){
                //取消关注成功
                that.closest('div.media').remove();
            }
            layer.msg(d.message);
            that.attr('disabled', false);
        });
        
    });
JS;


$this->registerJs($js);
?>
