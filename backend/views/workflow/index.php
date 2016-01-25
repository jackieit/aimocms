<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Workflow;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Workflows');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="workflow-index">


    <p>
        <?= Html::a(Yii::t('app', 'Create Workflow'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'intro:ntext',
            [
                'attribute'=>'is_inner',
                'value'    => function($model)
                {
                    $is_inner = Workflow::IS_INNER();
                    return $is_inner[$model->is_inner];
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' =>[
                    'list' => function($url,$model,$key){

                        return Html::a('<span class="fa fa-list-ol"></span>',['list','id'=>$model->id],[
                            'title'     => Yii::t('app','View step list'),
                            'data-pjax' =>'1',
                        ]);
                    }
                ],
                'template' => '{view} {update} {list} {delete}',
            ],
        ],
    ]); ?>
</div>
