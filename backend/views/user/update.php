<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UserForm */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => '',
]) . ' ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Forms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-form-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
