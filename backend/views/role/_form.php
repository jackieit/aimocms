<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\models\AuthCategory;
/* @var $this yii\web\View */
/* @var $model backend\models\AuthRole */
/* @var $form yii\widgets\ActiveForm */
$cate = ArrayHelper::map(AuthCategory::find()->all(),'id','name');
?>

<div class="auth-role-form">

    <?php
    $form = ActiveForm::begin();

    ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'cat_id',[
        'template' => "{label}\n<div class='input-group auth-cate'>{input}<span class=\"input-group-addon\"><i class=\"fa fa-plus\"></i></span></div> \n{hint}\n{error}"
    ])->dropDownList($cate,['prompt'=>'请选择分类']) ?>
    <?= $form->field($model, 'rules')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'controllers',[
        'template' => "{label}\n<div class='row'><div class=\"col-lg-5\">{input}\n{hint}\n{error}</div>"
            ."<div class='col-lg-1 text-center'><button type='button' class='btn btn-danger btn-block'><i class=\"fa  fa-arrow-circle-o-right\"></i></button><br/><br/><button type='button' class='btn btn-success btn-block'><i class=\"fa  fa-arrow-circle-o-left\"></i></button></div>"
            ."<div class='col-lg-5'>".Html::dropDownList('controllers',null,$this->context->getControllers(),['prompt'=>'请选择控制器','id'=>'controllers','class'=>'form-control','multiple'=>true,'style'=>'height:134px;'])."</div></div>"
    ])->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'actions',[
        'template' => "{label}\n<div class='row'><div class=\"col-lg-5\">{input}\n{hint}\n{error}</div>"
            ."<div class='col-lg-1 text-center'><button type='button' class='btn btn-danger btn-block'><i class=\"fa  fa-arrow-circle-o-right\"></i></button><br/><br/><button type='button' class='btn btn-success btn-block'><i class=\"fa  fa-arrow-circle-o-left\"></i></button></div>"
            ."<div class='col-lg-5'>".Html::dropDownList('controllers',null,[],['prompt'=>'先选择上面的控制器再选择action','id'=>'actions','class'=>'form-control','multiple'=>true,'style'=>'height:134px;'])."</div></div>"
    ])->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

$ajax_url = Url::to(['create-cate']);
$act_url = Url::to(['get-action']);
$js=<<<JS

$('.input-group-addon').click(function(){

      var cat_name = prompt("请输入分类名称");
      if(cat_name ==null || cat_name==''){
        return ;
      }
    $.ajax({
        url:'{$ajax_url}',
        data:'AuthCategory[name]='+cat_name,
        dataType: "json",
        method:'POST',
        success:function(data){
            if(typeof(data.selected) !=='undefined'){
                var src = data.data
                var html = '<option value="">分类名称</option>';
                for(var i=0;i<src.length;i++){
                    if(src[i].id==data.selected){
                       var sel = " selected='selected'";
                    }else{
                       var sel = '';
                    }
                    html+='<option value="'+src[i].id+'"'+sel+'>'+src[i].name+'</option>';
                }
                $('#authrole-cat_id').html(html);
            }else{
                if(data.length>0)
                alert(data.join("\\n"));
            }


        }
    });
});
$('#controllers').change(function() {
      var controller = $('#controllers option:selected').text();
      $.ajax({
        url:'{$act_url}',
        data:'controller='+controller,
        dataType: "json",
        method:'get',
        success:function(data){

                for(var i=0;i<data.length;i++){
                    if(data[i].id==data.selected){
                       var sel = " selected='selected'";
                    }else{
                       var sel = '';
                    }
                    html+='<option value="'+data[i].id+'"'+sel+'>'+data[i].name+'</option>';
                }
                $('#controller').html(html);
         }
    });
});
JS;
$this->registerJs($js);
?>
