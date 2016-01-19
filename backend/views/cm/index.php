<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Cm;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app','Content Model');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cm-index">


    <p>
        <?= Html::a(Yii::t('app','Create Cm'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'tab',
            [
                'attribute'=>'is_inner',
                'value'    => function($model)
                {
                    $is_inner = Cm::IS_INNER();
                    return $is_inner[$model->is_inner];
                }
            ],
            'site.name',
            [
                'attribute'=>'tab_index',
                'value'    => function($model)
                {
                    $tab_index = Cm::$TAB_INDEX;
                    return $tab_index[$model->tab_index];
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                 'buttons' => [
                     'update' => function($url,$model,$key){
                         if($model->is_inner==1) return '';
                         else
                             return Html::a('<span class="glyphicon glyphicon-pencil"></span>',['update','id'=>$model->id],['title'=>Yii::t('app','View')]);
                     },
                     'field' => function($url,$model,$key){

                             return Html::a('<span class="fa fa-th-list"></span>',['field','id'=>$model->id],['title'=>Yii::t('app','Field list view')]);
                     },
                     'delete' => function($url,$model,$key){
                         if($model->is_inner==1) return '';
                         else
                             return Html::a('<span class="glyphicon glyphicon-trash"></span>',['delete','id'=>$model->id],
                                 [
                                     'title'      => \Yii::t('app', 'Delete'),
                                     'aria-label' =>\Yii::t('app', 'Delete'),
                                     'data-pjax'  => '0',
                                     'data-confirm' => \Yii::t('app','Are you sure you want to delete this item?'),
                                     'data-method' => 'post',
                                 ]
                             );

                     }
                 ],
                'template' => '{view} {update} {delete} {field}'
            ],
        ],
    ]); ?>

</div>
