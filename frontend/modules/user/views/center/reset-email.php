<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
        <hr>
        <div class="row">
            <div class="cont-left col-md-8">
                <?php
                $form = ActiveForm::begin([
                    'id' => 'reset-password-form',
                    'options' => ['class' => 'form-horizontal'],
                ]) ?>
                <?= $form->field($model, 'password',[
                    'template' => '<div class="form-group">{label}<div class="col-sm-8">{input}{error}</div></div>',
                ])->passwordInput()->label('原密码',['class'=>'col-sm-2 control-label']) ?>

                <?= $form->field($model, 'email',[
                    'template' => '<div class="form-group">{label}<div class="col-sm-4">{input}{error}<button class="send-email btn btn-link">发送验证码</button></div></div>',
                ])->textInput()->label('邮箱',['class'=>'col-sm-2 control-label']) ?>


                <?= $form->field($model, 'captcha',[
                    'template' => '<div class="form-group">{label}<div class="col-sm-4">{input}{error}</div></div>',
                ])->textInput()->label('邮箱验证码',['class'=>'col-sm-2 control-label']) ?>


                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-11">
                        <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
                <?php ActiveForm::end() ?>
            </div>


            <?= $this->render('sidebar', [

            ]) ?>
        </div>
    </div>
</section>

<?php
$sendMail = Url::to(['/index/ajax-email-captcha']);
$js = <<<JS
    //点击发送验证码
    $('button.send-email').on('click', function(e){
        e.preventDefault();
        
        var area = $(this).closest('div.form-group').find('input');
        var that = $(this);
        
        
        //是否为空
        var mail = area.val();
        if(mail.length === 0){
            return false;
        }
        
        //验证格式
        var filter=/^([a-zA-Z0-9_\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{1,4})+$/;
        if(!filter.test(mail)){
            return false;
        }
        that.attr('disabled', true);
        
        
        //提交邮箱
        $.post("{$sendMail}","mail="+mail, function(d) {
            if (d.errcode === 0){
                //发送成功
                that.text(d.message);
                
                //定时器
                timer(that);
            }else{
                //发送失败
                that.text(d.message);
            }
        });
        
    });

    var keyr = null;
    function timer(that){
        clearInterval(keyr);
        
        var txt = that.text();
        var num = 60;
        keyr = setInterval(function(){
            
            num = num-1;
            that.text(txt + ' ' + num);
            if (num <= 0){
                clearInterval(keyr);
                keyr = null;
                that.text('点击发送');
                that.attr('disabled', false);
            }
        },1000)
    }
JS;

$this->registerJs($js);
?>