<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Workflow;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Workflow States');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="workflow-state-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Workflow State'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'val',
            [
                'attribute'=>'is_inner',
                'value'    => function($model)
                {
                    $is_inner = Workflow::IS_INNER();
                    return $is_inner[$model->is_inner];
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
