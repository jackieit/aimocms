<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\WorkflowState */

$this->title = Yii::t('app', 'Create Workflow State');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Workflow States'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="workflow-state-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
