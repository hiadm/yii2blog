<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\components\Helper;
use yii\widgets\LinkPager;


$this->registerCssFile('static/home/css/sublist.css',['depends'=>'frontend\assets\HomeAsset']);
$this->title = '专题列表';
?>

<!-- 主体 -->
<section class="content">
    <div class="container">
        <div class="row">
            <div class="sublist-title col-xs-12">
                <div class="font-pretty">
                    <p class="pull-left"><?= Html::encode($this->title)?></p>
                </div>
            </div>
            <div class="sublist-tab col-xs-12">
                <!-- 专题选项卡 -->
                <div class="subject-tab row">
                    <div class="col-md-6">

                        <!-- Nav tabs -->
                        <ul class="font-pretty font-size-12" id="nav_tabs">
                            <li class="<?= $type=='hot'? 'active' : ''?>">
                                <?= Html::a('<span class="glyphicon glyphicon-fire"></span>热门专题', ['', 'type' => 'hot']) ?>
                            </li>
                            <li class="<?= $type=='vip'? 'active' : ''?>">
                                <?= Html::a('<span class="glyphicon glyphicon-send"></span>VIP专题', ['', 'type' => 'vip']) ?>
                            </li>
                            <li class="<?= $type=='finished'? 'active' : ''?>">
                                <?= Html::a('<span class="glyphicon glyphicon-ok"></span>已完结', ['', 'type' => 'finished']) ?>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group" id="search_subject">
                            <input type="text" class="form-control" placeholder="搜索专题">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">搜索专题</button>
                            </span>
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
                </div>
            </div>
            <div class="sublist-items col-xs-12">
                <ul id="s_container">
                    <?php
                    if(!empty($subjects)):
                    foreach($subjects as $subject):
                    ?>
                    <li class="item col-xs-6 col-sm-6 col-md-4">
                        <div class="sub-wrap">
                            <a class="img" href="<?= Url::to(['view', 'id'=>$subject['id']])?>">
                                <img class="img-radius-8 img-responsive" src="<?= $subject['logo']?>">
                            </a>
                            <div class="cont text-center font-pretty">
                                <h3>
                                    <a class="title text-muted" href="<?= Url::to(['view', 'id'=>$subject['id']])?>">	<?= $subject['name']?></a>
                                </h3>
                                <p class="text-muted"><?= Helper::truncate_utf8_string(Html::encode($subject['desc']),30)?></p>
                                <p>
                                    <?php if(empty($subject['isAttention'])):?>
                                        <a class="intry" href="<?= Url::to(['attention','sid'=>$subject['id']])?>">点击关注</a>
                                    <?php else:?>
                                        <a class="intry ready">已关注</a>
                                    <?php endif;?>
                                </p>
                                <p class="text-muted">收录<?= $subject['total']?>篇文章</p>
                            </div>
                        </div>
                    </li>
                    <?php
                    endforeach;
                    endif;
                    ?>
                </ul>
                <nav aria-label="Page navigation">
                    <?= LinkPager::widget([
                        'pagination' => $pagination,
                    ])?>
                </nav>
            </div>
        </div>
    </div>
</section>

<?php
$getSubjects = Url::to(['/content/subject/ajax-subjects']);
$attentionUrl = Url::to(['attention']);
$ajaxAttention = Url::to(['ajax-attention']);
$js = <<<JS
    //选项卡
    $('#nav_tabs').find('li').on('click',function(){
        //选项卡样式
        $(this).addClass('active').siblings('li').removeClass('active');

    });


    //搜索专题
    $('#search_subject').find('button').on('click', function(){
        var val = $('#search_subject').find('input').val();
        
        //数据验证
        if(val == '')
            return false;
        //清空容器
        var container = $('#s_container');
        container.empty();
        var index = layer.load(0, {shade: false});
        //请求专题
        $.ajax({
           type: "get",
           url: "{$getSubjects}",
           data: "name=" + val,
           success: function(data){
            if (data.errcode === 0){
                 //请求成功
                 var str = '';
                 var tmp = '';
                 var data = data.data;
                 for(var item in data){
                    
                     if(data[item]['isAttention'] === true)
                         tmp = '<a class="intry ready" href="javascript:;">已关注</a>';
                     else
                         //tmp = '<a class="intry" href="'+ "{$attentionUrl}" +'&sid='+ data[item].id +'">点击关注</a>';
                         tmp = '<a class="intry attend-btn" data-sid="'+ data[item].id +'" href="javascript:;">点击关注</a>';
                     
                     str += '<li class="item col-xs-6 col-sm-6 col-md-4"><div class="sub-wrap"><a class="img" href="/index.php?r=content%2Fsubject%2Fview&amp;id='+data[item].id+'"><img class="img-radius-8 img-responsive" src="'+data[item].logo+'"></a><div class="cont text-center font-pretty"><h3><a class="title text-muted" href="/index.php?r=content%2Fsubject%2Findex&amp;id='+data[item].id+'">	'+data[item].name+'</a></h3><p class="text-muted">'+data[item].desc+'</p><p>'+ tmp +'</p><p class="text-muted">收录'+data[item].total+'篇文章</p></div></div></li>';
                 }
                 layer.close(index);
                 container.html(str);
             }else{
                 //请求失败
                 container.html(data.message);
             }
           }
        });
        
    });
    
    
    //Ajax关注专题
    $('#s_container').on('click', 'a.attend-btn', function(){
        var sid = $(this).data('sid');
        var that = $(this);
        $.get("{$ajaxAttention}", { sid: sid },
          function(data){
            
            if (data.errcode === 0){
                //关注成功
                that.addClass('ready').removeClass('attend-btn').text('已关注');
                
            }
            layer.msg(data.message);
            
        });
        
        
    });
    
   

JS;


$this->registerJs($js);
?>

