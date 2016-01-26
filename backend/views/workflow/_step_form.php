<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\WorkflowStep;
/* @var $this yii\web\View */
/* @var $model backend\models\WorkflowStep */
/* @var $form ActiveForm */
?>
<div class="step-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'wf_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'role_id') ?>
    <?= $form->field($model, 'append_note')->dropDownList(WorkflowStep::appendNode(),['prompt' => Yii::t('app','Select append note')]) ?>
    <?= $form->field($model, 'intro') ?>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'before_state')->hint(Yii::t('app','If more than one state split by slashes')) ?>
    <?= $form->field($model, 'after_state')->hint(Yii::t('app','If more than one state split by slashes'))  ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- step-create -->