<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthRole */

$this->title = Yii::t('app', 'Update Auth Role: ') . ' ' . $model->description;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Auth Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->description];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="auth-role-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
