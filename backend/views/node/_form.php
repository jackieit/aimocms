<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Workflow;
use backend\models\Cm;
use backend\models\Node;
use backend\assets\AutoCompleteAsset;
/* @var $this yii\web\View */
/* @var $model backend\models\Node */
/* @var $form yii\widgets\ActiveForm */
AutoCompleteAsset::register($this);

$root = Node::find()->where(['site_id' => $site_id])->one();
$leaves = $root->children()->all();
$data   = [];
$data[] = ['data'=>$root->id,'value'=>'┣'.$root->id.'|'.$root->name];

foreach($leaves as $leaf){
    $data[] = ['data'=>$leaf->id,'value'=>'┣'.str_repeat('━',$leaf->depth).$leaf->id.'|'.$leaf->name];
}
$data = json_encode($data,JSON_UNESCAPED_UNICODE);
?>

<div class="node-form">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-lg-2',
                //'offset' => 'col-sm-offset-4',
                'wrapper' => 'col-lg-8',
                'error' => 'col-lg-8',
                'hint' => 'col-lg-8',
            ],
        ],
    ]); ?>

    <?= $form->field($model, 'site_id')->hiddenInput()->label(false) ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_real')->inline(true)->radioList(Node::isReal())->hint(Yii::t('app','V Nodes can link other real nodes'),['class'=>'help-block col-lg-offset-2 col-lg-10']) ?>

    <?= $form->field($model, 'v_nodes')->textarea(['rows' => 2]) ?>
    <?= Html::activeHiddenInput($model,'parent')?>
    <?= $form->field($model, 'cm_id')->dropDownList(ArrayHelper::map(Cm::find()->all(),'id','name'),['prompt'=>Yii::t('app','Please select content model')])->hint(Yii::t('app','When selected ,can not modify')) ?>

    <?= $form->field($model, 'parent_txt')->textInput(['placeHolder'=>Yii::t('app','Please input Node id or Node name to select').Yii::t('app','When selected ,can not modify')]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'workflow')->dropDownList(ArrayHelper::map(Workflow::find()->all(),'id','name'),['prompt'=>Yii::t('app','Please select workflow')]) ?>

    <?= $form->field($model, 'tpl_index')->textInput(['maxlength' => true])->hint(Yii::t('app','Please fill the template name relative the site template,no need file extension')) ?>

    <?= $form->field($model, 'tpl_detail')->textInput(['maxlength' => true])->hint(Yii::t('app','Please fill the template name relative the site template,no need file extension')) ?>

    <?php //$form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_keyword')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
//$data = json_encode(Node::getSiteNodes($site_id),JSON_UNESCAPED_UNICODE);

$js =<<<JS

var nodeinfo = {$data};

$('.field-node-v_nodes').hide();
$('#node-is_real input').click(
 function(){

     if($(this).val()=='1'){
         $('.field-node-v_nodes').hide();
         $('.field-node-cm_id').show();
         $('#node-cm_id option[value=""]').attr('selected',true);
         $('#node-cm_id option[value=1]').attr('selected',false);

     }else{
         $('.field-node-v_nodes').show();
         $('.field-node-cm_id').hide();
         $('#node-cm_id option[value=""]').attr('selected',false);
         $('#node-cm_id option[value=1]').attr('selected',true);
         //$('#node-cm_id').val('1');

     }
 });
    $('#node-parent_txt').autocomplete({
        delimiter:'|',
        lookup: nodeinfo,
        minChars:0,
        onSearchStart:function(query){
            $('#node-parent').val('');
        },
        onSelect: function (suggestion) {
            $('#node-parent').val(suggestion.data);

        }
    });
JS;
$this->registerJs($js);
?>