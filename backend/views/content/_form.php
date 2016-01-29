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
   // height: 500,
    theme: 'modern',
    plugins: [
        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars code fullscreen',
        'insertdatetime media nonbreaking save table contextmenu directionality',
        'emoticons template paste textcolor colorpicker textpattern imagetools'
      ],
    images_upload_url: 'postAcceptor.php',
    images_upload_base_path: '/uploads/',
    images_upload_credentials: true,
    paste_data_images: true
});
JS_CODE;

}
$dateInput = $dateTimeInput=[];

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
                    $options = array_merge(['maxlength' => true],$field['options']);
                    $input->{$field['input']}($options)->label($field['label']);
                    break;
                case 'hiddenInput':
                    $input->{$field['input']}($field['options'])->label(false);
                    break;
                case 'fileInput':
                    $input->{$field['input']}($field['options'])->label($field['label']);
                    break;
                case 'radio':
                case 'checkbox':

                $input->{$field['input']}($field['options'])->label($field['label']);
                    break;
                case 'dropDownList':
                    $extra_opt = ['prompt'=>Yii::t('app','Please select')];
                case 'checkboxList':
                case 'radioList':
                    $data = $model->getSource($field['source']);
                    if(isset($extra_opt))
                        $field['options'] = array_merge($field['options'],$extra_opt);
                    $input->{$field['input']}($data,$field['options'])->label($field['label']);
                    break;
                case 'richEditor':
                    $options = array_merge(['class'=>'richEditor'],$field['options']);
                    $input->textarea($options)->label($field['label']);
                    break;
                case 'datePicker':

                case 'datetimePicker':
                    if($field['input']=='datePicker') {
                        $fname = &$field['name'];
                        array_push($dateInput, $fname);
                    }else{
                        $fname = &$field['name'];
                        array_push($dateTimeInput,$fname);
                    }

                    $input = $form->field($model,$field['name'],[
                        'template' => "{label}\n<div class='input-group' id='picker-{$fname}'>{input}<span class=\"input-group-addon\"><i class=\"fa fa-calendar\"></i></span></div> \n{hint}\n{error}"
                    ]);
                    $options = array_merge(['class'=>'form-control'],$field['options']);
                    $input->textInput($options)->label($field['label']);
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
if(in_array('datePicker',$inputType) || in_array('datetimePicker',$inputType))
{
    \backend\assets\DatetimeAsset::register($this);
    $langs = strtolower(Yii::$app->language);
}
$datePickId = '';
foreach($dateInput as $el){
    $datePickId='#picker-'.$el.',';
}
$datePickId = trim($datePickId,',');
$dateTimePickId = '';
foreach($dateTimeInput as $el){
    $dateTimePickId='#picker-'.$el.',';
}
$dateTimePickId = trim($dateTimePickId,',');
if(!empty($datePickId))
$js.=<<<JS_CODE

    $('{$datePickId}').datetimepicker({
        locale: '{$langs}',
        format:'YYYY-MM-DD'
    });
JS_CODE;
if(!empty($dateTimePickId))
   $js.=<<<JS_CODE

    $('{$dateTimePickId}').datetimepicker({
        locale: '{$langs}',
        format:'YYYY-MM-DD HH:mm:ss'
    });

JS_CODE;
$this->registerJs($js);
?>