<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Site */
/* @var $form yii\widgets\ActiveForm */
$model->is_publish = 0;
$model->url        = "@web";
$model->res_path   = '@frontend/web/static';
$model->res_url    = '@web/static/';
?>

<div class="site-form">

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

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'domain_txt')->textarea(['maxlength' => true,'rows'=> 4])->hint(Yii::t('app','The first is main domain')) ?>

    <?= $form->field($model, 'template')->textInput(['maxlength' => true])->hint(\Yii::t('app','Only input template name eg. example.com')) ?>

    <?= $form->field($model, 'is_publish')->inline(true)->radioList(['1' => Yii::t('app','Yes'),'0'=>Yii::t('app','No')])->hint(Yii::t('app','Alone publish will copy view script to site dir'),['class'=>'help-block col-lg-8 col-lg-offset-2']); ?>

    <?= $form->field($model, 'path')->textInput(['maxlength' => true])->hint(\Yii::t('app','Absolute path or relative or ftp path')) ?>

    <?= $form->field($model, 'dsn')->textInput(['maxlength' => true])->hint((\Yii::t('app','Publish database dsn'))) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true])->hint((\Yii::t('app','Publish site homepage'))) ?>

    <?= $form->field($model, 'res_path')->textInput(['maxlength' => true])->hint((\Yii::t('app','Absolute path or relative or ftp path'))) ?>

    <?= $form->field($model, 'res_url')->textInput(['maxlength' => true])->hint((\Yii::t('app','Resource url'))) ?>

    <?= $form->field($model, 'page_404')->textInput(['maxlength' => true])->hint((\Yii::t('app','Page 404 template name'))) ?>

    <?= $form->field($model, 'beian')->textInput(['maxlength' => true])->hint((\Yii::t('app','ICP beian no'))) ?>

    <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_keyword')->textarea(['maxlength' => true])?>

    <?= $form->field($model, 'seo_description')->textarea(['maxlength' => true]) ?>

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
