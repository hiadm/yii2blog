<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Tag */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tag-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

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
            !empty($curSubject) ? $curSubject : []
        )->label(false) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$getSubjectUrl = Url::to(['subject/ajax-get-subjects']);
$js = <<<JS


    //搜索专题
    $('#searchSubject').on('click', function(){
        var val = $('#subject_name').val();
        if (val == '')
            return;
        
        var container = $('#tag-subject_id');
        var loading = $('#loading');
        
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
                     subjects = data.data;
                     var str = '';
                     for(var item in subjects){
                         str += '<label><input type="radio" name="Tag[subject_id]" value="'+ subjects[item]['id']+ '">' +subjects[item]['name']+ '</label>';
                     }
                     container.html(str);
                 }else{
                     //没有专题数据
                     container.html('<p class="text-danger">'+data.message+'</p>');
                 }
           }
    
        });
    });


JS;
$this->registerJs($js);



?>




