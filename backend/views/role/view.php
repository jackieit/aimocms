<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model backend\models\AuthRole */

$this->title = Yii::t('app', 'View') . ' ' . $model->description;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Auth Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->description];
$this->params['breadcrumbs'][] = Yii::t('app', 'View');
?>
<div class="auth-role-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-success']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            //'auth_key',
            'description',
            //'password_reset_token',
            'authCategory.name',
            'controllers',
            'actions',
        ],
    ]) ?>
</div>
