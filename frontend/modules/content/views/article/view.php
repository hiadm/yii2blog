<?php
use yii\helpers\Html;
use common\components\Helper;
use yii\helpers\Url;
use frontend\assets\JsmartyAsset;
use yii\widgets\LinkPager;
use yii\web\View;

JsmartyAsset::register($this);
$this->registerCssFile('static/home/css/content.css',['depends'=>'frontend\assets\HomeAsset']);

$this->title = $article['title'] . ' - ' .$this->params['siteInfo']['name'];
$this->registerMetaTag(array("name"=>"keywords","content"=>"{$article['title']},{$this->params['siteInfo']['name']}"));
$this->registerMetaTag(array("name"=>"description","content"=>"{$article['brief']}"));
?>

<!-- 主体 -->
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <!-- 文章内容 -->
                <div class="art-cont font-pretty">
                    <div class="article">
                        <div class="title">
                            <h2><?= Html::encode($article['title'])?></h2>
                        </div>
                        <div class="posted">
                            <a class="photo" href="javascript:void(0);">
                                <img src="<?= !empty($user['photo'])?$user['photo']:$this->params['userPhoto']?>">
                            </a>
                            <div class="name text-muted">
                                <a href="#"><?= $user['username']?></a>
                                <i class="type copy">
                                    <?php
                                        $tmp = ['原创','转载','翻译'];
                                        echo $tmp[$article['type']];
                                    ?>
                                </i>
                                <?php
                                    if($article['isbest'] == 1){
                                        echo '<i class="type pull">推荐</i>';
                                    }
                                ?>
                                <p>
                                    发布 <?= Yii::$app->formatter->asRelativeTime($article['created_at']);?>,
                                    字数 <?= Helper::strlen_utf8($article['content'])?>,
                                    阅读 <?= $article['visited']?$article['visited']:0;?>,
                                    喜欢 <?= $article['favorite']?$article['favorite']:0;?>,
                                    收藏 <?= $article['collect']?$article['collect']:0;?>,
                                    <span>专题 <?= Html::a($article['subject']['name'], ['subject/view', 'id'=>$article['subject']['id']])?></span>
                                </p>

                            </div>

                        </div>
                        <div class="data">
                            <div class="clearfix"></div>
                            <!-- 文章内容 -->
                            <div data-note-content="" class="show-content">

                                <?php
                                    //如果不是vip专题的文章 或者 你是vip用户
                                    if(!$visible['vipArticle'] || ($visible['isLogin'] && $visible['vipUser'])){

                                        echo $article['content'];
                                    }else{
                                        if($visible['isLogin'])
                                            echo '<div class="well well-lg text-danger">您还不是vip用户 不能查看此内容</div>';
                                        else{
                                            echo '<div class="well well-lg">请先<a href="'.Url::to(Yii::$app->user->loginUrl) .'"> 登录</a></div>';
                                        }
                                    }




                                ?>
                            </div>
                            <div class="heart">
                                <div class="heart-l pull-left">
                                    <ul>
                                        <!-- 打赏 -->
                                        <li>
                                            <a id="sponsor" href="JavaScript:void(0);">￥打赏｡◕‿◕｡</a>
                                        </li>
                                        <!-- 喜欢 -->
                                        <li>
                                            <?php if($article['favorite']):?>
                                                <a class="ready" href="JavaScript:void(0);">已喜欢</a>
                                            <?php else:?>
                                                <a class="favorite_btn" href="JavaScript:void(0);">♡喜欢</a>
                                            <?php endif;?>
                                        </li>
                                        <!-- 收藏 -->
                                        <li>
                                            <?php if($article['collect']):?>
                                                <a class="ready" href="JavaScript:void(0);">已收藏</a>
                                            <?php else:?>
                                                <a class="collect_btn" href="JavaScript:void(0);">+收藏</a>
                                            <?php endif;?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="nextprev">
                                <div class="prev">
                                    <a class="btn btn-info" type="submit" href="<?= $prevAndNext['prev']['url']?>">
                                        上一篇
                                    </a>
                                    <a class="text-muted" href="<?= $prevAndNext['prev']['url']?>"><?= $prevAndNext['prev']['title']?></a>
                                </div>
                                <p></p>
                                <div class="next">
                                    <a class="btn btn-success" type="submit" href="<?= $prevAndNext['next']['url']?>">
                                        下一篇
                                    </a>
                                    <a class="text-muted" href="<?= $prevAndNext['next']['url']?>"><?= $prevAndNext['next']['title']?></a>
                                </div>
                            </div>
                        </div>
                        <div class="comment">
                            <!-- 发表评论 -->
                            <div class="row">
                                <div class="col-xs-2 col-sm-1 posted">
                                    <a class="photo" href="javascript:void(0);">
                                        <?php if(!Yii::$app->user->isGuest && !empty(Yii::$app->user->identity->photo)):?>
                                            <img src="<?= Yii::$app->user->identity->photo?>">
                                        <?php else:?>
                                            <img src="<?= Yii::$app->params['userPhoto']?>">
                                        <?php endif;?>
                                    </a>
                                </div>
                                <div class="col-xs-10 col-sm-11">

                                    <?= Html::beginForm(null, 'post',[
                                            'id' => 'comment_form'
                                    ]) ?>
                                    <input type="hidden" name="aid" value="<?= $article['id']?>">
                                    <div class="textform">
                                        <textarea name="content" class="form-control" rows="5" placeholder="说点什么吧..." <?= Yii::$app->user->isGuest?'disabled':''?> id="textarea"></textarea>

                                        <?php if(Yii::$app->user->isGuest):?>
                                        <div class="mode">
                                            <div class="sincelogin text-center">
                                                <?= Html::a('登录', Yii::$app->user->loginUrl)?> &nbsp; 后发表评论！
                                            </div>
                                        </div>
                                        <?php endif;?>
                                    </div>
                                    <div class="postbtn">
                                        <span class="pull-right">

			    							<input class="btn btn-link" type="reset" name="" value="取消">
			    							<button id="send_btn" class="btn btn-success">发射<span class="glyphicon glyphicon-send" aria-hidden="true"></span></button>
			    						</span>
                                    </div>
                                    <?= Html::endForm() ?>

                                </div>
                            </div>
                            <!-- 评论计数 -->
                            <div class="row">
                                <div class="col-xs-12">
                                    <p class="comment-count"><span><?= $commentNum?></span>条评论 </p>
                                </div>
                            </div>
                            <hr>
                            <!-- 评论列表 -->
                            <div id="comment_container">
                                <?php foreach($comments as $comment):?>
                                <div class="row">
                                    <div class="col-xs-12 comment-data to-name">
                                        <div class="comment-author">
                                            <div class="photo pull-left">
                                                <a class="photo" href="javascript:void(0);">
                                                    <img src="<?= empty($comment['user']['photo'])?Yii::$app->params['userPhoto']:$comment['user']['photo'];?>">
                                                </a>
                                            </div>
                                            <div class="info pull-left">
                                                <p class="text-primary"><span class="to-name"><?= $comment['user']['username']?></span></p>
                                                <p class="text-muted"><?= date('Y-m-d H:i:s', $comment['created_at'])?></p>
                                            </div>
                                        </div>
                                        <div class="comment-str">
                                            <p><?= Html::encode($comment['content'])?></p>
                                        </div>
                                        <div class="comment-zan" data-cid="<?= $comment['id']?>">
                                            <p>
                                                <span><a class="txt-link zan" href="javascript:void(0);"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> <span class="zan-num"><?= $comment['likes']?></span>人赞</a></span>&nbsp;&nbsp;
                                                <span><a class="txt-link hui" href="javascript:void(0);"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> 回复</a></span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 comment-reply">
                                        <!-- 回复 -->
                                        <div class="reply-list" data-cid="<?= $comment['id']?>" data-aid="<?= $article['id']?>">

                                            <!-- 回复列表容器-->
                                            <div class="replys">
                                                <?php foreach($comment['replys'] as $reply):?>
                                                    <div class="reply-item to-name">
                                                        <p> <span class="text-primary to-name"><?= $reply['user']['username']?></span> : <span class="text-warning"><?php $comment['user']['username']?></span><?= Html::encode($reply['content'])?></p>
                                                        <p class="comment-zan">
                                                            <?= date('Y-m-d H:i:s',$reply['created_at'])?>
                                                            <a class="hui" href="javascript:void(0);">回复</a>
                                                        </p>
                                                    </div>
                                                <?php endforeach;?>
                                            </div>

                                            <!-- 回复框-->
                                            <div class="in-txt">

                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <hr>
                                <?php endforeach;?>


                            </div>
                            <!--/评论列表容器-->

                            <nav id="pager" aria-label="Page navigation">
                                <?= LinkPager::widget([
                                    'pagination' => $pagination,
                                    'nextPageLabel' => false,
                                    'prevPageLabel' => false,
                                ]);?>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<?php
$imgUrl = $article['user']['sponsor'];
if(!empty($imgUrl)){
    $content = "<img width='350' height='350' src='{$imgUrl}'/>";
}else{
    $content = "<p style='padding: 50px;'>暂无设置</p>";
}

$string = <<<JS
    $('#sponsor').on('click', function(){
        layer.open({
          title : false,
          type: 1,
          skin: 'layui-layer-rim', //加上边框
          
          content: "{$content}"
        });
    });
JS;
$this->registerJs($string);

?>

<?php
$favoriteUrl = Url::to(['ajax-favorite']);
$collectUrl = Url::to(['ajax-collect']);
$commitCommentUrl = Url::to(['comment/ajax-commit']);
$js = <<<JS
    var flag = true;
    //点击喜欢
    $('.favorite_btn').on('click', function(){
        if(!flag)
            return;
        flag = false;
        
        var that = $(this);
        if(that.text() === '♡喜欢'){
            $.get("{$favoriteUrl}", "aid={$article['id']}", function(data){
                console.log(data);
                if (data.errcode === 0){
                    //添加成功
                    that.addClass('ready').removeClass('favorite_btn').text('已喜欢');
                }
                layer.msg(data.message);
                
            });
            
        }
        setTimeout(function(){
            flag = true;
        },3000);
        
    });
    //点击收藏
    $('.collect_btn').on('click', function(){
        if(!flag)
            return;
        flag = false;
        
        var that = $(this);
        if(that.text() === '+收藏'){
            $.get("{$collectUrl}", "aid={$article['id']}", function(data){
            if (data.errcode === 0){
                //添加成功
                that.addClass('ready').removeClass('favorite_btn').text('已收藏');
            }
            layer.msg(data.message);
            
            });
            
        }
        setTimeout(function(){
            flag = true;
        },3000);
    });
    //发送评论
    $('#send_btn').on('click', function(e){
        e.preventDefault();
        var that = $(this);
        sendComment(that);
        
    });
    //发送评论函数
    function sendComment(obj){
        var txtAr = $('#textarea');
        var txtFo = $('#comment_form');
        var txtVal = txtAr.val().trim();
        if (txtVal.trim().length === 0) {
            txtAr.focus();
            return false;
        }
        obj.attr('disabled', true);
        
        //评论容器
        var container = $('#comment_container');
        
        //获取模板
        var tplText = $('#comment-tpl').html();
        //创建jsmart
        var compiled = new jSmart( tplText );
        
        var count = $('.comment-count').find('span');
        
        
        $.ajax({
           type: "POST",
           url: "{$commitCommentUrl}",
           data: txtFo.serialize(),
           success: function(d){
             
             if(d.errcode === 0){
                 //提交评论成功
                 var res = compiled.fetch( d.data );
                 container.prepend(res);
                 
                 //评论数累加
                 count.text(parseInt(count.text()) + 1) ;
                 txtAr.val('');
             }
             //消息
             layer.msg(d.message);
             obj.attr('disabled',false);
             
           }
        });
    }
JS;

$this->registerJs($js);
?>
<?php
$likes = Url::to(['comment/ajax-zan']);
$replyUrl = Url::to(['reply/ajax-commit']);
$js2 = <<<JS
    //评论容器
    var container = $('#comment_container');
    var zan = true;
    //评论点赞
    container.on('click', '.comment-zan a.zan', function(){
        if(!zan)
            return;
        zan = false;
        
        var that = $(this);
        if(that.hasClass('text-danger')){
            return false;
        }
        var cid = $(this).closest('div').data('cid');
        $.ajax({
           type: "POST",
           url: "{$likes}",
           data: "cid=" + cid,
           success: function( d ){
             if(d.errcode === 0){
                 //点赞成功
                 var num = parseInt(that.find('span.zan-num').text()) + 1;
                 that.find('span.zan-num').text(num);
                 that.removeClass('txt-link').addClass('text-danger');
             }else{
                 layer.msg(d.message);
             }
             zan = true;
           }
        });
        setTimeout(function(){
            zan = true;
        },5000);
        
    });

    //回复框显示
    container.on('click', '.comment-zan a.hui', function(){
        //获取回复容器
        var coContainer = $(this).closest('div.row');
        
        //获取评论容器
        var reContainer = coContainer.find('.reply-list');
        
        //获取模板
        var tplText = $('#reply-input').html();
        
        //测试
        var name = $(this).closest('div.to-name').find('span.to-name').text();
        var compiled = new jSmart( tplText );
        var res = compiled.fetch( { name:'@' + name + ' : ' } );
        reContainer.find('.in-txt').html(res);
    });
    
    //提交回复
    container.on('click', '.reply-form button', function(){
        var that = $(this);
        that.attr('disabled', true);
        
        //回复容器
        var reContainer = $(this).closest('div.reply-list');
        var inputWrap = reContainer.find('.in-txt');
        var listWrap = reContainer.find('.replys');
        //获取当前回复内容
        var txt = $(this).closest('div.reply-form').find('input').val();
        
        if ( txt.trim().length === 0 )
            return false;
        
        //文章id 和评论id
        var aid = reContainer.data('aid');
        var cid = reContainer.data('cid');
        $.ajax({
            type : 'post',
            url  : "{$replyUrl}",
            data : "aid="+aid+"&cid="+cid+"&txt="+txt,
            success : function(d){
                if ( d.errcode === 0 ){
                    //回复成功
                    fillTpl(d.data, listWrap); //填充模板
                    inputWrap.empty(); //删除输入框
                }else{
                    //回复失败
                    layer.msg( d.message );
                    that.attr('disabled', false);
                }
            }
        });
        
    });
    
    //填充回复消息
    function fillTpl(d, ele){
        var tplText = $('#reply-item').html();
        var compiled = new jSmart( tplText );
        var res = compiled.fetch( d );
        ele.append(res);
        
    }

JS;

$this->registerJs($js2);
?>
<?php
$ajaxPage = Url::to(['article/ajax-get-comments']);
$pageJs = <<<JS
    var pager = true;
    $(document).on('click','.pagination a',function(e){
        e.preventDefault();
        
        if(!pager)
            return;
        pager = false;
        
        var that = $(this);
        
        //是否是激活状态
        var isActive = $(this).closest('li').hasClass('active');
        if (isActive)
            return false;
        
        var page=$(this).data('page');
        
        $.get("{$ajaxPage}", 'page=' + page + '&aid=' + "{$article['id']}",function(d){
            
            var tplText = $('#comment-page').html();
            var compiled = new jSmart( tplText );
            var res = compiled.fetch( {comments : d.data} );
            $('#comment_container').html(res);
            
            //添加高亮
            that.closest('nav#pager').html(d.pager);
            
        });
        setTimeout(function(){
            pager = true;
        },1500);
    });
JS;

$this->registerJs($pageJs);
?>
<script id="comment-tpl" type="text/x-smarty-tmpl">
    <div class="row">
        <div class="col-xs-12 comment-data to-name">
            <div class="comment-author">
                <div class="photo pull-left">
                    <a class="photo" href="javascript:void(0);">
                        <img src="{$photo}">
                    </a>
                </div>
                <div class="info pull-left">
                    <p class="text-primary"><span class="to-name">{$username}</span></p>
                    <p class="text-muted">{$time}</p>
                </div>
            </div>
            <div class="comment-str">
                <p>{$content}</p>
            </div>
            <div class="comment-zan" data-cid="{$cid}">

            </div>
        </div>
        <div class="col-xs-12 comment-reply">
            <!-- 回复 -->
            <div class="reply-list">
                <!-- 回复列表容器-->
                <div class="replys">

                </div>
                <!--输入框-->
                <div class="in-txt">

                </div>
            </div>
        </div>

    </div>
    <hr>
</script>
<script id="reply-input" type="text/x-smarty-tmpl">
    <div class="row">
        <div class="col-lg-12">
            <div class="input-group reply-form">
                <input value="{$name}" type="text" class="form-control">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">提交</button>
                </span>
            </div>
        </div>
    </div>
</script>
<script id="reply-item" type="text/x-smarty-tmpl">
    <div class="reply-item">
        <p>
            <span class="text-primary">{$username}</span> :
            {$txt}
        </p>
        <p>
            {$time}
        </p>
    </div>
</script>
<script id="comment-page" type="text/x-smarty-tmpl">
{foreach $comments as $i => $comment}
    <div class="row">
        <div class="col-xs-12 comment-data to-name">
            <div class="comment-author">
                <div class="photo pull-left">
                    <a class="photo" href="javascript:void(0);">
                        <img src="{$comment.user.photo}">
                    </a>
                </div>
                <div class="info pull-left">
                    <p class="text-primary"><span class="to-name">{$comment.user.username}</span></p>
                    <p class="text-muted">{$comment.created_at}</p>
                </div>
            </div>
            <div class="comment-str">
                <p>{$comment.content}</p>
            </div>
            <div class="comment-zan" data-cid="{$comment.id}">
                <p>
                    <span><a class="txt-link zan" href="javascript:void(0);"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> <span class="zan-num">{$comment.likes}</span>人赞</a></span>&nbsp;&nbsp;
                    <span><a class="txt-link hui" href="javascript:void(0);"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> 回复</a></span>
                </p>
            </div>
        </div>
        <div class="col-xs-12 comment-reply">
            <!-- 回复 -->
            <div class="reply-list" data-cid="{$comment.id}" data-aid="{$comment.article_id}">
                <!-- 回复列表容器-->
                <div class="replys">
                    {foreach $comment.replys as $k => $reply}
                    <div class="reply-item to-name">
                        <p> <span class="text-primary to-name">{$reply.user.username}</span> : {$reply.content}
                        <p class="comment-zan">
                            {$reply.created_at}
                            <a class="hui" href="javascript:void(0);">回复</a>
                        </p>
                    </div>
                    {foreachelse}
                    {/foreach}
                </div>
                <!-- 回复框-->
                <div class="in-txt">

                </div>
            </div>
        </div>
    </div>
    <hr />
{foreachelse}
{/foreach}
</script>

