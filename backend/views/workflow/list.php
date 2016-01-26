<?php
use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\WorkflowStep;
use backend\models\Workflow;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\Workflow */

$this->title = Yii::t('app', 'View step list');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Workflows'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $wf->name, 'url' => ['view', 'id' => $wf->id]];
?>

<div class="workflow-index">


    <p>
        <?= Html::a(Yii::t('app', 'Create Step'), ['step-create','wf_id'=>$wf->id], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'before_state',
            'after_state',
            [
                'attribute'=>'append_note',
                'value' => function($model){
                    $an = WorkflowStep::appendNode();
                    return ArrayHelper::getValue($an,$model->append_note);
                }
            ],
            'intro',


            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function($url,$model,$key)
                    {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',['step-update','id'=>$model->id],[
                            'data-pjax' => 1,
                            'title'  => Yii::t('app','Update')
                        ]);
                    },
                    'delete' => function($url,$model,$key)
                    {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',['step-delete','id'=>$model->id],[
                            'data-pjax'=> 1,
                            'title' => Yii::t('app','Delete'),
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('app','Are you sure you want to delete this item?')
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>
</div>
