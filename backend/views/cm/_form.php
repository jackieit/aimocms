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

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$site_url = Url::to(['site/get-sites']);
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
JS;
$this->registerJs($js);
?>
