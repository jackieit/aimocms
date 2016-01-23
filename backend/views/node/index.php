<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Node;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Nodes');
$this->params['breadcrumbs'][] = ['label' => $site->name, 'url' => ['index','site_id'=>$site->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="node-index">


    <p>
        <?= Html::a(Yii::t('app', 'Create Node'), ['create','site_id'=>$site->id], ['class' => 'btn btn-success','data-pjax'=>0]) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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

            // 'v_nodes:ntext',
            // 'parent',
            // 'slug',
            // 'workflow',
            // 'tpl_index',
            // 'tpl_detail',
            // 'status',
            // 'seo_title',
            // 'seo_keyword',
            // 'seo_description',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
