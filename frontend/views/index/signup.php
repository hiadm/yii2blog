<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = $this->params['siteInfo']['name'] .' - '. '用户登陆';

?>
<section class="signup">
    <div class="container-fliud">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <div class="wrap">
                    <div class="core">
                        <h4 class="title text-center">
                            <a  href="<?= Url::to(Yii::$app->user->loginUrl)?>">登录</a>
                            <b>.</b>
                            <a class="active" href="javascript:void(0);">注册</a>
                        </h4>
                        <div class="inputs">
                            <?php
                            $form = ActiveForm::begin([
                                'id' => 'login-form',
                                'fieldConfig' => [
                                    'template' => '{label}{input}{error}',
                                ],
                            ])
                            ?>
                            <?= $form->field($model, 'username')->textInput()?>
                            <?= $form->field($model, 'password')->passwordInput()?>
                            <?= $form->field($model, 're_password')->passwordInput()?>
                            <div class="input-group form-group">
                                <?= $form->field($model, 'email',[
                                        'template' => '{label}<div class="input-group form-group">{input}<a href="javascript:void(0);" class="input-group-addon btn" id="basic-addon2">发送验证码</a></div>{error}'
                                ])->textInput(['aria-describedby'=>"basic-addon2"])?>

                            </div>
                            <?= $form->field($model, 'captcha',[
                                'template' =>"{input} &nbsp;{label}{error}",
                                'options'=>['class'=>'form-inline']
                            ])->textInput()?>


                            <?= Html::submitButton('点击注册', ['class' => 'btn btn-success']) ?>
                            <?= Html::a('已有账号 去登陆', ['/index/login'], ['class' => 'profile-link pull-right']) ?>
                            <?php ActiveForm::end() ?>
                        </div>
                        <div class="authorize text-center text-muted">
                            <h6>————— 社交帐号直接注册 —————</h6>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


</section>
<?php
$sendMail = Url::to(['/index/ajax-email-captcha']);
$js = <<<JS
    var keyr = null;
    $('a#basic-addon2').on('click', function(){
        //判断定时器是否存在
        
        if(keyr)
            return false;
        keyr = true;
        
        var area = $(this).closest('div').find('input');
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
            }
        },1000)
    }
    
JS;


$this->registerJs($js);
?>