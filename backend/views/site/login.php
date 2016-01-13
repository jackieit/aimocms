<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\assets\AppAsset;
AppAsset::register($this);

$this->title = 'Aimo CMS 用户登录';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
<?php $this->beginBody() ?>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?=$this->title?></h3>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                        <fieldset>
                            <?=$form->field($model,'username')->textInput(['placeholder'=>'用户名'])->label(false)?>

                            <?=$form->field($model,'password')->passwordInput(['placeholder'=>'密码'])->label(false)?>
                            <div class="checkbox">
                                <?= $form->field($model, 'rememberMe')->checkbox()->label('记住我') ?>
                            </div>
                            <div class="form-group">
                            <?= Html::submitButton('登录', ['class' => 'btn btn-lg btn-success btn-block', 'name' => 'login-button']) ?>
                            </div>

                        </fieldset>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>

    </body>
</html>
<?php $this->endPage() ?>
