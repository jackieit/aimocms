<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\Content */
/* @var $form yii\widgets\ActiveForm */
$fields = $model->getFields();
$inputType = ArrayHelper::getColumn($fields,'input');
$js = '';
if(in_array('richEditor',$inputType)){
    \backend\assets\TinyMceAsset::register($this);
    $langs = str_replace('-','_',Yii::$app->language);
    $plugins = '';
$js .=<<<JS_CODE
tinymce.init({
    selector:'.richEditor' ,
    language:'{$langs}',
    height: 500,
    theme: 'modern',
    plugins: [
        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars code fullscreen',
        'insertdatetime media nonbreaking save table contextmenu directionality',
        'emoticons template paste textcolor colorpicker textpattern imagetools'
      ]
});
JS_CODE;

}

?>

<div class="content-form">

    <?php $form = ActiveForm::begin(); ?>
    <?
        foreach($fields as $field):
            $input = $form->field($model,$field['name']);
            switch ($field['input']) {
                case 'textInput':
                case 'passwordInput':
                case 'textarea':
                    $input->{$field['input']}(['maxlength' => true])->label($field['label']);
                    break;
                case 'hiddenInput':
                    $input->{$field['input']}()->label(false);
                    break;
                case 'fileInput':
                    $input->{$field['input']}()->label($field['label']);

                    break;
                case 'radio':
                case 'checkbox':
                    $input->{$field['input']}()->label($field['label']);
                    break;
                case 'dropDownList':
                case 'checkboxList':
                case 'radioList':
                    break;
                case 'richEditor':
                    $input->textarea(['class'=>'richEditor'])->label($field['label']);
                    break;
                case 'datePicker':
                case 'datetimePicker':
                    break;

                default:
                    ;
            }
            if(!empty($field['hint'])){
                $input->hint($field['hint']);
            }
            echo $input;
        endforeach;
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs($js);
?>