<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\CmField;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = Yii::t('app','Field list view');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Content Model'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $cm->name,'url'=>['view','id'=>$cm->id]];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cm-index">

    <p>
        <?= Html::a(Yii::t('app','Create Field'), ['field-create','cm_id'=>$cm->id], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>
    <?php
        $form = ActiveForm::begin();
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' =>'sort',
                'value' => function($model){
                    return Html::hiddenInput('fid[]',$model->id).Html::textInput('sort[]',$model->sort,['class'=>'form-control field-sort']);
                },
                'format' => 'raw',
            ],
            'name',
            'label',
            'hint',
            [
                'attribute'=>'is_inner',
                'value'    => function($model)
                {
                    $is_inner = CmField::IS_INNER();
                    return $is_inner[$model->is_inner];
                }
            ],
            [
                'attribute'=>'data_type',
                'value'    => function($model)
                {
                    $dt = CmField::dataType();
                    return $dt[$model->data_type];
                }
            ],
            'length',
            [
                'attribute'=>'input',
                'value'    => function($model)
                {
                    $dt = CmField::inputType();
                    return $dt[$model->input];
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function($url,$model,$key){

                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',['field-view','id'=>$model->id],['title'=>Yii::t('app','View')]);
                    },
                    'update' => function($url,$model,$key){
                        if($model->is_inner==1) return '';
                        else
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>',['field-update','id'=>$model->id],['title'=>Yii::t('app','View')]);
                    },

                    'delete' => function($url,$model,$key){
                        if($model->is_inner==1) return '';
                        else
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>',['field-delete','id'=>$model->id,'cm_id'=> $model->cm_id],
                                [
                                    'title'      => \Yii::t('app', 'Delete'),
                                    'aria-label' =>\Yii::t('app', 'Delete'),
                                    'data-pjax'  => '0',
                                    'data-confirm' => \Yii::t('app','Are you sure you want to delete this item?'),
                                    'data-method' => 'post',
                                ]
                            );

                    }
                ]
            ],
        ],
    ]); ?>
    <p>
        <?= Html::submitButton(Yii::t('app','Field sort'),  ['class' => 'btn btn-danger']) ?>
    </p>
    <?php ActiveForm::end();?>
<?php Pjax::end(); ?></div>
