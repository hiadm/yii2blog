<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Seo */

$this->title = '设置 SEO';
$this->params['breadcrumbs'][] = '设置 SEO';
?>
<div class="seo-update">

    <div class="seo-form box box-primary">
        <?php $form = ActiveForm::begin(); ?>
        <div class="box-body table-responsive">
            <div class="col-lg-6">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

                <?= $form->field($model, 'about')->textarea(['maxlength' => true]) ?>

            </div>
            <div class="col-lg-6 keyval">
                <label>快速通道 </label> <i>最多可写5个</i>
                <?php if(!empty($quicks)):?>
                    <?php foreach($quicks as $quick):?>
                    <div class="form-inline">
                        <div class="form-group">
                            <label class="sr-only" for="exampleInputEmail3">name</label>
                            <input value="<?= $quick['name']?>" name="Seo[quicks_name][]" type="text" class="form-control" id="exampleInputEmail3" placeholder="名字">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="exampleInputPassword3">uel</label>
                            <input value="<?= $quick['url']?>" name="Seo[quicks_url][]" type="text" class="form-control" id="exampleInputPassword3" placeholder="URL">
                        </div>
                        <a type="submit" class="btn btn-default plus">+</a>
                        <a type="submit" class="btn btn-default reduce">-</a>
                        <p></p>
                    </div>
                    <?php endforeach;?>
                <?php else:?>
                    <div class="form-inline">
                        <div class="form-group">
                            <label class="sr-only" for="exampleInputEmail3">name</label>
                            <input name="Seo[quicks_name][]" type="text" class="form-control" id="exampleInputEmail3" placeholder="名字">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="exampleInputPassword3">uel</label>
                            <input name="Seo[quicks_url][]" type="text" class="form-control" id="exampleInputPassword3" placeholder="URL">
                        </div>
                        <a type="submit" class="btn btn-default plus">+</a>
                        <a type="submit" class="btn btn-default reduce">-</a>
                        <p></p>
                    </div>
                <?php endif;?>



                <hr>
                <label>关注我</label> <i>最多可写3个</i>
                <?php if(!empty($follows)):?>
                    <?php foreach($follows as $follow):?>
                    <div class="form-inline">
                        <div class="form-group">
                            <label class="sr-only" for="exampleInputEmail3">name</label>
                            <input value="<?= $follow['name']?>" name="Seo[follows_name][]" type="text" class="form-control" id="exampleInputEmail3" placeholder="微博">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="exampleInputPassword3">uel</label>
                            <input value="<?= $follow['url']?>" name="Seo[follows_url][]" type="text" class="form-control" id="exampleInputPassword3" placeholder="URL">
                        </div>
                        <a type="submit" class="btn btn-default plus">+</a>
                        <a type="submit" class="btn btn-default reduce">-</a>
                        <p></p>
                    </div>
                    <?php endforeach;?>
                <?php else:?>
                    <div class="form-inline">
                        <div class="form-group">
                            <label class="sr-only" for="exampleInputEmail3">name</label>
                            <input name="Seo[follows_name][]" type="text" class="form-control" id="exampleInputEmail3" placeholder="github">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="exampleInputPassword3">uel</label>
                            <input name="Seo[follows_url][]" type="text" class="form-control" id="exampleInputPassword3" placeholder="URL">
                        </div>
                        <a type="submit" class="btn btn-default plus">+</a>
                        <a type="submit" class="btn btn-default reduce">-</a>
                        <p></p>
                    </div>
                <?php endif;?>

            </div>

        </div>
        <div class="box-footer">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success btn-flat']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>

<?php
$js = <<<JS
    //点击添加输入框
    $('.keyval').on('click', 'a.plus', function(){
        var block = $(this).closest('div.form-inline');
        var du_block = block.clone();
        block.after(du_block);
    });

    //点击减少输入框
    $('.keyval').on('click', 'a.reduce', function(){
        var block = $(this).closest('div.form-inline');
        block.remove();
    });
JS;

$this->registerJs($js);
?>

