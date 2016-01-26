<?php
/** @var backend\models\WorkflowStep $model */
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Workflow */

$this->title = Yii::t('app', '{modelClass}: ', [
        'modelClass' => Yii::t('app', 'Create Step'),
    ]) ;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Workflows'), 'url' => ['list','wf_id'=>$wf->id]];
//$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="step-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_step_form',[
        'model'=>$model,
    ]);?>
</div>