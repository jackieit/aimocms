<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Node;
//use backend\assets\TableDndAsset;
use backend\assets\SortableListAsset;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

SortableListAsset::register($this);
$this->title = Yii::t('app', 'Nodes');
$this->params['breadcrumbs'][] = ['label' => $site->name, 'url' => ['index','site_id'=>$site->id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="node-index">


    <form class="form-inline">
        <div class="form-group">
        <?= Html::a(Yii::t('app', 'Create Node'), ['create','site_id'=>$site->id], ['class' => 'btn btn-success','data-pjax'=>0]) ?>
        <?= Html::a(Yii::t('app', 'Sort Move Node'), ['sort','site_id'=>$site->id], ['class' => 'btn btn-success','data-pjax'=>0]) ?>
        </div>

    </form>
    <?php
    echo
    GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function($model){
            return ['id'=> 'row_'.$model->id];
        },
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            //'site_id',
            [
                'attribute' => 'name',
                'value' => function($model)
                {
                    return str_repeat('━',$model->depth).$model->name;
                }
            ],
            [
                'attribute'=>'is_real',
                'value' => function($model){
                    return Node::isReal()[$model->is_real];
                }
            ],
            [
                'attribute'=>'status',
                'value' => function($model){
                   return  Node::nodeStatus()[$model->status];
                },
            ],
            'cm.name',


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);

    ?>
</div>
