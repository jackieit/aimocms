<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\CmField;
/* @var $this yii\web\View */
/* @var $model backend\models\CmField */
/* @var $form ActiveForm */
if($model->isNewRecord)
    $this->title = Yii::t('app','Create Field');
else{
    $this->title = Yii::t('app','Update Field');
    $model->old_name = $model->name;
}
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Content Model'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $cm->name,'url'=>['view','id'=>$cm->id]];

$this->params['breadcrumbs'][] = $this->title;
$model->is_inner = 2;

?>
<div class="field-create">
    <h3><?=$this->title?></h3>
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'cm_id')->hiddenInput()->label(false) ?>


        <?= $form->field($model, 'name')->hint(Yii::t('app','Used for database table field name')) ?>
        <?= $form->field($model, 'is_inner')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'old_name')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'label') ?>
        <?= $form->field($model, 'hint') ?>
        <?= $form->field($model, 'data_type')->dropDownList(CmField::dataType(),['prompt'=> Yii::t('app','Prompt datatype')]) ?>
        <?= $form->field($model, 'length')->hint(Yii::t('app','useful for string and decimal datatype')) ?>
        <?= $form->field($model, 'input')->dropDownList(CmField::inputType(),['prompt'=> Yii::t('app','Prompt inputtype')]) ?>
        <?= $form->field($model, 'source')->textarea()->hint(Yii::t('app','support key value pair per line or sql statement')) ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>
<!-- field-create -->
