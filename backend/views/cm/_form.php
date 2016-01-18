<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Cm;
/* @var $this yii\web\View */
/* @var $model common\models\Cm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cm-form">

    <?php $form = ActiveForm::begin(
    ); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tab')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_inner')->dropDownList(Cm::IS_INNER()) ?>

    <?= $form->field($model, 'site_id')->textInput() ?>

    <?= $form->field($model, 'tab_index')->dropDownList(Cm::$TAB_INDEX) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
