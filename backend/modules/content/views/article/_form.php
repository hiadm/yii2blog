<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use mdm\admin\components\Helper as MdmHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form box box-primary">
    <?php $form = ActiveForm::begin([
//        'enableClientValidation'=>false,
        'options' => [
            'onkeydown'=>"if(event.keyCode==13){return false;}"
        ],
    ]); ?>
    <div class="box-body table-responsive">
        <div class="row">
            <div class="col-lg-8">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'brief')->textarea(['maxlength' => true]) ?>

                <?= $form->field($model, 'smallimg')->widget('manks\FileInput', [
                    'clientOptions' => [
                        /*'pick' => [
                            'multiple' => true,
                        ],*/
                    ]
                ]);  ?>
                <hr>

                <?= $form->field($model, 'isbest')->radioList([
                    '0' => '普通文章',
                    '1' => '精品推荐',
                ],[
                    'id' => 'best_btn'
                ])->label(false) ?>

                <div class="imgfile">
                    <div id="bigimg">
                        <?= $form->field($model, 'bigimg')->widget('manks\FileInput', [
                            'clientOptions' => [
                                /*'pick' => [
                                    'multiple' => true,
                                ],*/
                            ]
                        ]);  ?>
                    </div>
                </div>

                <hr>

            </div>
            <div class="col-lg-4">
                <?php //$form->field($model, 'subject_id')->textInput(['maxlength' => true]) ?>


                <babel for="subject_name"><strong>选择专题</strong></babel>
                <p></p>
                <div class="input-group">
                    <input id="subject_name" type="text" class="form-control" placeholder="搜索专题">
                    <span class="input-group-btn">
                        <button id="searchSubject" class="btn btn-default" type="button">立即搜索!</button>
                    </span>
                </div><!-- /input-group -->
                <p></p>

                <div id="loading" class="hidden">
                    <img id="loadingimg" src="/static/img/loading1.gif"/>
                </div>

                <?= $form->field($model, 'subject_id',[
                    'template' => '{label}{input}{error}'
                ])->radioList(
                    $curSubject
                )->label(false) ?>

                <hr>

                <!--选择标签-->

                <?= $form->field($model, 'tag_ids',[
                    'template' => '{label}<div id="loading-tags" class="hidden"><img id="loadingimg" src="/static/img/loading1.gif"/></div>{input}{error}<p class="tags-help text-danger">选择专题后 自动陈列可用标签.</p>'
                ])->checkboxList(
                    $curTags
                ) ?>

                <hr>

                <?php
                if(MdmHelper::checkRoute('tag/create')) {
                    echo $form->field($model, 'tag_str',[
                        'template' => '{label}{input}{error}<p class="text-danger">新建标签，多个用逗号分割。.</p>'
                    ])->textInput();

                }

                ?>

                <!--新建标签-->
                <?php $form->field($model, 'tag_str',[
                    'template' => '{label}{input}{error}<p class="text-danger">新建标签，多个用逗号分割。.</p>'
                ])->textInput()?>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?= $form->field($model, 'content')->textarea(['maxlength' => true,'rows'=>8]) ?>
                <?= $form->field($model, 'type')->radioList([
                    '0' => '原创',
                    '1' => '转载',
                    '2' => '翻译',
                ])->label(false) ?>
                <?= $form->field($model, 'isdraft')->radioList([
                    '0' => '直接发布',
                    '1' => '存为草稿',
                ])->label(false) ?>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('立即发射', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php
$getSubjectUrl = Url::to(['subject/ajax-get-subjects']);
$getTagsUrl = Url::to(['tag/ajax-get-tags']);
$js = <<<JS
    //搜索专题
    $('#searchSubject').on('click', function(){
        var val = $('#subject_name').val();
        if (val == '')
            return;
        
        var container = $('#article-subject_id');
        var loading = $('#loading');
        $('#article-tag_ids').empty();
        
        loading.removeClass('hidden');
        container.html('');
        
        $.ajax({
           type: "POST",
           url: "{$getSubjectUrl}",
           data: "subject=" + val,
           success: function(data){
                
               //隐藏loading
                 loading.addClass('hidden');
                 if(!data.errorno){
                     //有数据
                     var subjects = data.data;
                     var str = '';
                     for(var item in subjects){
                         str += '<label><input type="radio" name="Article[subject_id]" value="'+ subjects[item]['id']+ '">' +subjects[item]['name']+ '</label>';
                     }
                     container.html(str);
                 }else{
                     //没有专题数据
                     container.html('<p class="text-danger">'+data.message+'</p>');
                 }
           }
    
        });
    });

    //是否是精品推荐
    $('#best_btn :radio').on('change', function(e){
        var val = this.value;
        if(val == 1){
            $('#bigimg').fadeIn();
        }else{
            $('#bigimg').fadeOut();
        }
    });
    
    //显示指定专题下的所有标签
    $('#article-subject_id').on('change', ':radio', function(){
        var val = $(this).val();
        
        if(!val)
            return false;
        
        var tag_ids = $('#article-tag_ids');
        var loading = $('#loading-tags');
        //var helper = $('.tags-help');
        
        loading.removeClass('hidden');
        tag_ids.empty();
        
        //Ajax请求相关标签
        $.ajax({
            type: 'post',
            url: "{$getTagsUrl}",
            data: 'subject_id=' + val,
            success: function(data){
                loading.addClass('hidden');
                
                if(!data.errorno){
                    //有匹配专题
                    var str = '';
                    $.each(data.data, function(key, val){
                        str += '<label><input type="checkbox" name="Article[tag_ids][]" value="'+ val.id +'">'+ val.name +'</label>';
                    });
                    
                    tag_ids.html(str);
                }else{
                    //没有匹配数据
                    tag_ids.html(data.message);
                }
            }
        });
    });
JS;
$this->registerJs($js);



?>