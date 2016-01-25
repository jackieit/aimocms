<?php
use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Workflow;
/* @var $this yii\web\View */
/* @var $model backend\models\Workflow */

$this->title = Yii::t('app', 'View step list');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Workflows'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $wf->name, 'url' => ['view', 'id' => $wf->id]];
?>

<div class="workflow-index">


    <p>
        <?= Html::a(Yii::t('app', 'Create Step'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'before_state',
            'after_state',
            'append_note',
            'intro',


            [
                'class' => 'yii\grid\ActionColumn',

            ],
        ],
    ]); ?>
</div>
