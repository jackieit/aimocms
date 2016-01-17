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
    <?= $form->field($model, 'controllers[]',[
        'template' => "{label}\n<div class='row'><div class=\"col-lg-5\">{input}\n{hint}\n{error}</div>"
            ."<div class='col-lg-1 text-center'><button type='button' class='btn btn-danger btn-block' id=\"bt-controller-remove\"><i class=\"fa  fa-arrow-circle-o-right\"></i></button>"
            ."<br/><button type='button' class='btn btn-success btn-block' id=\"bt-controller-add\"><i class=\"fa  fa-arrow-circle-o-left\"></i></button></div>"
            ."<div class='col-lg-5'>".Html::dropDownList('controllers',null,$this->context->getControllers(),['prompt'=>'请选择控制器','id'=>'controllers','class'=>'form-control','multiple'=>true,'size'=>'4'])."</div></div>"
    ])->dropDownList(explode(',',$model->controllers),['prompt' => '从右边添加控制器','multiple'=>true,'size'=>'4']) ?>
    <?= $form->field($model, 'actions[]',[
        'template' => "{label}\n<div class='row'><div class=\"col-lg-5\">{input}\n{hint}\n{error}</div>"
            ."<div class='col-lg-1 text-center'><button type='button' class='btn btn-danger btn-block' id=\"bt-action-remove\"><i class=\"fa  fa-arrow-circle-o-right\"></i></button>"
            ."<br/><button type='button' class='btn btn-success btn-block' id=\"bt-action-add\"><i class=\"fa  fa-arrow-circle-o-left\"></i></button></div>"
            ."<div class='col-lg-5'>".Html::dropDownList('actions',null,[],['prompt'=>'先选择上面的控制器再选择action','id'=>'actions','class'=>'form-control','multiple'=>true,'size'=>'4'])."</div></div>"
    ])->dropDownList(explode(',',$model->actions),['prompt' => '从右边添加action','multiple'=>true,'size'=>'4']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

$ajax_url = Url::to(['category-create']);
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
      if(controller=='请选择控制器')return;
      $.ajax({
        url:'{$act_url}',
        data:'controller='+controller,
        dataType: "json",
        method:'get',
        success:function(data){
            var html = '<option value="">先选择上面的控制器再选择action</option>';
            for(var e in data){

                html+='<option value="'+e+'">'+data[e]+'</option>';
            }
            $('#actions').html(html);
         }
    });
});
$("#bt-controller-add").click(function(){
    addOption('controllers','authrole-controllers');
});
$('#bt-controller-remove').click(function(){
    removeOption('authrole-controllers');
});
$("#bt-action-add").click(function(){
    addOption('actions','authrole-actions');
});
$('#bt-action-remove').click(function(){
    removeOption('authrole-actions');
});
function addOption(from ,to){
    $('#'+from+' option:selected').each(function(){
        $('#'+to).append("<option value='"+$(this).val()+"'>"+$(this).text()+"</option>");
    });
    var map = {};
    $('#'+to+' option').each(function () {
        if (map[this.value]) {
            $(this).remove()
        }
        map[this.value] = true;
    })
}
function removeOption(from){
     $('#'+from+' option:selected').each(function(){
           $(this).remove();
    });
}
$('#w0').submit(function(){
    $('#authrole-controllers option,#authrole-actions option').each(function(){
        if($(this).text().indexOf('@')!=-1)
            $(this).attr('value',$(this).text());
        $(this).attr("selected","selected");
    });
});

JS;
$this->registerJs($js);
?>
