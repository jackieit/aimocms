<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Workflow;
use backend\models\Cm;
use backend\models\Node;
use backend\assets\AutoCompleteAsset;
/* @var $this yii\web\View */
/* @var $model backend\models\Node */
/* @var $form yii\widgets\ActiveForm */
AutoCompleteAsset::register($this);

$root = Node::find()->where(['site_id' => $site_id])->one();
$leaves = $root->children()->andFilterWhere( ['>','status',0])->all();
$data   = [];
$data[] = ['data'=>$root->id,'value'=>'┣'.$root->id.'|'.$root->name];

foreach($leaves as $leaf){
    $data[] = ['data'=>$leaf->id,'value'=>'┣'.str_repeat('━',$leaf->depth).$leaf->id.'|'.$leaf->name];
}
$data = json_encode($data,JSON_UNESCAPED_UNICODE);

?>

<div class="node-form">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-lg-2',
                //'offset' => 'col-sm-offset-4',
                'wrapper' => 'col-lg-8',
                'error' => 'col-lg-8',
                'hint' => 'col-lg-8',
            ],
        ],
    ]); ?>

    <?= $form->field($model, 'site_id')->hiddenInput()->label(false) ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_real')->inline(true)->radioList(Node::isReal())->hint(Yii::t('app','V Nodes can link other real nodes'),['class'=>'help-block col-lg-offset-2 col-lg-10']) ?>

    <?= $form->field($model, 'v_nodes')->textarea(['rows' => 2]) ?>
    <?= Html::activeHiddenInput($model,'parent')?>
    <?= $form->field($model, 'cm_id')->dropDownList(ArrayHelper::map(Cm::find()->all(),'id','name'),['prompt'=>Yii::t('app','Please select content model')])->hint(Yii::t('app','When selected ,can not modify')) ?>

    <?= $form->field($model, 'parent_txt')->textInput(['placeHolder'=>Yii::t('app','Please input Node id or Node name to select').Yii::t('app','When selected ,can not modify')]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'workflow')->dropDownList(ArrayHelper::map(Workflow::find()->all(),'id','name'),['prompt'=>Yii::t('app','Please select workflow')]) ?>

    <?= $form->field($model, 'tpl_index')->textInput(['maxlength' => true])->hint(Yii::t('app','Please fill the template name relative the site template,no need file extension')) ?>

    <?= $form->field($model, 'tpl_detail')->textInput(['maxlength' => true])->hint(Yii::t('app','Please fill the template name relative the site template,no need file extension')) ?>

    <?php //$form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_keyword')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel"><?=Yii::t('app', 'Nodes select box')?></h4>
            </div>
            <div class="modal-body">
                <ul style="max-height: 300px;overflow: auto;">
                <?php
                $stack = new SplStack();
                if(isset($leaves[0]));
                $stack->push($leaves[0]->depth);
                foreach($leaves as $k=> $item)
                {

                    if ($item->depth > $stack->top()) {
                        $stack->push($item->depth);
                        echo "<ul>\n";
                    }
                    while (!$stack->isEmpty() && $stack->top() > $item->depth) {
                        $stack->pop();
                        echo "</ul></li>\n";
                    }
                    echo"<li class='form-group'><div class='checkbox'><label>".Html::checkbox('nid',false,['value'=>$item->id,'class'=>'nodes-box'])."{$item->id}.".$item->name."</label></div>\n";
                }
                while ($stack->count() > 1) {
                    $stack->pop();
                    echo "</ul>\n</li>\n";
                }
                ?>
                </ul>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal"><?=Yii::t('app','Close')?></button>
             </div>
        </div>
    </div>
</div>

<?php
//$data = json_encode(Node::getSiteNodes($site_id),JSON_UNESCAPED_UNICODE);
$is_real = $model->isNewRecord?1:$model->is_real;
$js =<<<JS

var nodeinfo = {$data};
var is_real  = '{$is_real}';
if(is_real=='1')
$('.field-node-v_nodes').hide();
else
$('.field-node-v_nodes').show();
$('#node-is_real input').click(
     function(){

         if($(this).val()=='1'){
             $('.field-node-v_nodes').hide();
             $('.field-node-cm_id').show();
             $('#node-cm_id option[value=""]').attr('selected',true);
             $('#node-cm_id option[value=1]').attr('selected',false);

         }else{
             $('.field-node-v_nodes').show();
             $('.field-node-cm_id').hide();
             $('#node-cm_id option[value=""]').attr('selected',false);
             $('#node-cm_id option[value=1]').attr('selected',true);
             //$('#node-cm_id').val('1');

         }
     }
 );
$('#node-parent_txt').autocomplete({
    delimiter:'|',
    lookup: nodeinfo,
    minChars:0,
    onSearchStart:function(query){
        $('#node-parent').val('');
    },
    onSelect: function (suggestion) {
        $('#node-parent').val(suggestion.data);

    }
});

var v_nodes_str = $('#node-v_nodes').val().trim();
if(v_nodes_str!='')
    var v_nodes = v_nodes_str.split(',');
else
    var v_nodes = [];
$('.checkbox input').each(function(){
    var pos = $.inArray($(this).val(),v_nodes);
    if(pos!=-1){
        $(this).prop("checked",true);
    }
});
$('#node-v_nodes').focus(function(){
    $('#exampleModal').modal();
});
function addNode(val){
    if($.inArray(val,v_nodes) == -1){
        v_nodes.push(val);
        $('#node-v_nodes').val(v_nodes.join(","));
    }
}
function removeNode(val){
    var pos = $.inArray(val,v_nodes);
    if( pos != -1){
        v_nodes.splice(pos,1);
        $('#node-v_nodes').val(v_nodes.join(","));
    }
}
$('.checkbox input').click(function(){
    if($(this).prop("checked")){
        addNode($(this).val());
    }else{
        removeNode($(this).val());
    }
});
JS;
$this->registerJs($js);
?>