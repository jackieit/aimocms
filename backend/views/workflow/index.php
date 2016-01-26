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
        <?= Html::a(Yii::t('app', 'Create Workflow State'), ['state-create'], ['class' => 'btn btn-primary']) ?>

    </p>
    <div class="panel panel-default">
        <div class="panel-heading">
            <?=Yii::t('app','Workflow States')?>
        </div>
        <div class="panel-body">
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

                        return Html::a('<span class="fa fa-list-ol"></span>',['list','wf_id'=>$model->id],[
                            'title'     => Yii::t('app','View step list'),
                            'data-pjax' =>'1',
                        ]);
                    }
                ],
                'template' => '{update} {list} {delete}',
            ],
        ],
    ]); ?>
            </div>
        </div>
</div>

<div id="work-state">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?=Yii::t('app','Workflow States')?>
        </div>
        <div class="panel-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider2,
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

                    [
                      'class' => 'yii\grid\ActionColumn',

                        'buttons' => [
                            'update' => function($url,$model,$key)
                            {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>',['state-update','id'=>$model->id],[
                                    'data-pjax' => 1,
                                    'title'  => Yii::t('app','Update')
                                ]);
                            },
                            'delete' => function($url,$model,$key)
                            {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>',['state-delete','id'=>$model->id],[
                                    'data-pjax'=> 1,
                                    'title' => Yii::t('app','Delete'),
                                    'data-method' => 'post',
                                    'data-confirm' => Yii::t('app','Are you sure you want to delete this item?')
                                ]);
                            }
                        ],
                      'template' => '{update} {delete}'

                    ],
                ],
            ]); ?>
        </div>

    </div>

</div>
