<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ContentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'color') ?>

    <?= $form->field($model, 'author') ?>

    <?= $form->field($model, 'from') ?>

    <?php // echo $form->field($model, 'photo') ?>

    <?php // echo $form->field($model, 'intro') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'seo_title') ?>

    <?php // echo $form->field($model, 'seo_keyword') ?>

    <?php // echo $form->field($model, 'seo_description') ?>

    <?php // echo $form->field($model, 'tpl_detail') ?>

    <?php // echo $form->field($model, 'file_name') ?>

    <?php // echo $form->field($model, 'slug') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
