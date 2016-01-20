<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\Cm;;
use backend\assets\AutoCompleteAsset;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\Cm */
/* @var $form yii\widgets\ActiveForm */
AutoCompleteAsset::register($this);
?>

<div class="cm-form">

    <?php $form = ActiveForm::begin(
    ); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tab')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'is_inner')->dropDownList(Cm::IS_INNER()) ?>
    <?= $form->field($model, 'site_id')->hiddenInput() ?>

    <?= Html::textInput('site_text','',['id'=>'site_txt','placeholder'=>'请输入网站域名或网站名称关键字','class'=>'form-control']); ?>


    <?= $form->field($model, 'tab_index')->dropDownList(Cm::$TAB_INDEX) ?>
    <?= $form->field($model, 'title_field')->textInput() ?>
    <?= $form->field($model, 'select_field')->textInput() ?>
    <?= $form->field($model, 'rules')->textarea(['rows'=> 5])->hint(Yii::t('app','use yii2 rules from this field')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::Button( Yii::t('app','Create Default Rule'), ['class' =>'btn btn-warning','id'=>'gen-rule']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$site_url = Url::to(['site/get-sites']);
$rule_url = Url::to(['rule']);
$action = $model->isNewRecord;
$cm_id  = $model->id;
$lang   = Yii::t('app','Please create field first');
$js = <<<JS
    $('#site_txt').autocomplete({
        delimiter:'|',
        lookup: function (query, done) {

             $.ajax({
                type: 'GET',
                url: '{$site_url}'+"&q="+$('#site_txt').val() ,
                async:false,
                dataType: 'json',
                success: function(data){

                    var result ={
                        suggestions:data
                    }
                    done(result);
                }
            });

        },
        onSearchStart:function(query){

            $('#cm-site_id').val('');
        },
        onSelect: function (suggestion) {
            $('#cm-site_id').val(suggestion.data);

        }
    });
    $('#gen-rule').click(function(){
        var act = '{$action}';
        if(act=='1'){
            alert("{$lang}");
            return;
        }
        var cm_id = '{$cm_id}';
         $.ajax({
            type: 'GET',
            url: '{$rule_url}'+"&id="+cm_id ,
            async:false,
            dataType: 'text',
            success: function(data){
                $('#cm-rules').val(data);
            }
        });

    });
JS;
$this->registerJs($js);
?>
