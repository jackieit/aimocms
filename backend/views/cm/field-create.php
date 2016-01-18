<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\CmField;
/* @var $this yii\web\View */
/* @var $model common\models\CmField */
/* @var $form ActiveForm */
$this->title = Yii::t('app','Field list view');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Content Model'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $cm->name,'url'=>['view','id'=>$cm->id]];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="field-create">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'cm_id')->hiddenInput()->label(false) ?>


        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'is_inner')->dropDownList(CmField::IS_INNER()) ?>
        <?= $form->field($model, 'label') ?>
        <?= $form->field($model, 'hint') ?>
        <?= $form->field($model, 'data_type')->dropDownList(CmField::dataType()) ?>
        <?= $form->field($model, 'length') ?>
        <?= $form->field($model, 'input') ?>
        <?= $form->field($model, 'source') ?>
        <?= $form->field($model, 'rules') ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- field-create -->
