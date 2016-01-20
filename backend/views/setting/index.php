<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
 /* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
 $this->title = Yii::t('app', 'Settings');
$this->params['breadcrumbs'][] = $this->title;
?>
 <div class="setting-index">

    <p>
        <?= Html::button(Yii::t('app', 'Create Setting'), ['class' => 'btn btn-success','data-toggle'=>"modal","data-target"=>"#exampleModal",'id'=>'btn-create']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'var',
            'val',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'delete' => function($url,$model,$key){
                        if($model->is_inner ==1) return '';
                        else
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',['index','id'=>$model->var]);
                    }
                ],
                'template' => '{delete} {update}'
            ],
        ],
    ]); ?>

</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel"><?=Yii::t('app', 'Create Setting')?></h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'action'=> $model->isNewRecord?Url::to(['create']):Url::to(['update','id'=>$model->var]),
                    'enableAjaxValidation' => true,
                ]); ?>

                <?= $form->field($model, 'var')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'val')->textInput(['maxlength' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>

<?php
$update = $model->isNewRecord?0:1;
$js = <<<JS
    var update = {$update};
    if(update){
       // $('#exampleModal').modal();
        $('#btn-create').trigger('click');
    }
JS;
$this->registerJs($js);
?>