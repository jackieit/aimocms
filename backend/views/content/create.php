<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Content */

$this->title = Yii::t('app', 'Create Content');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= $this->render('_form', [
        'model' => $model,
        'nodeinfo'=> $nodeinfo
    ]) ?>

