<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'List Auth Category');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-role-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'List Auth Roles'), ['index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'List Auth Category'), ['category-list'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function($url, $model, $key){

                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>','javascript:void(0);',
                                [
                                'title'      => \Yii::t('app', 'Update'),
                                'aria-label' =>\Yii::t('app', 'Update'),
                                'data-pjax'  => $model->id,
                                'class' => 'edit',
                                ]
                        );
                    },
                    'delete' => function($url,$model,$key){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',['category-delete','id'=>$model->id],
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
                'template' => '{update} &nbsp;{delete}'
            ],
        ],
    ]); ?>
</div>
<?php
$ajax_url = Url::to(['category-edit']);
$self = Yii::$app->request->getUrl();
$js = <<<JS
$('.edit').click(function(){
      var cat_name = prompt("请输入分类名称");
      if(cat_name ==null || cat_name==''){
        return ;
      }
      var id = $(this).attr('data-pjax');
    $.ajax({
        url:'{$ajax_url}&id='+id,
        data:'AuthCategory[name]='+cat_name,
        dataType: "json",
        method:'POST',
        success:function(data){
            if(data.success==1){
                alert('编辑分类成功');
                window.location.reload();
            }else{
                alert('编辑分类失败');
            }
        }
    });
});
function edit(id){

}

JS;
$this->registerJs($js);
?>