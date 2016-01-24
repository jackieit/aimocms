<?php

use yii\helpers\Html;

use backend\assets\SortableListAsset;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

SortableListAsset::register($this);
$this->title = Yii::t('app', 'Nodes');
$this->params['breadcrumbs'][] = ['label' => $site->name, 'url' => ['index','site_id'=>$site->id]];
$this->params['breadcrumbs'][] = $this->title;

//http://www.sitepoint.com/forums/showthread.php?651162-Build-nested-UL-and-LI-from-linear-array

?>
<div class="node-index">


    <form class="form-inline">
        <div class="form-group">
        <?= Html::a(Yii::t('app', 'Create Node'), ['create','site_id'=>$site->id], ['class' => 'btn btn-success','data-pjax'=>0]) ?>
        <?= Html::a($site->name, ['sort','site_id'=>$site->id], ['class' => 'btn btn-success','data-pjax'=>0]) ?>
        </div>

    </form>

    <div class="row">
        <ul id="myList" class="col-lg-8">
            <?php
            $stack = new SplStack();
            if(isset($list[0]));
                $stack->push($list[0]->depth);
            foreach($list as $k=> $item)
            {

                if ($item->depth > $stack->top()) {
                    $stack->push($item->depth);
                    echo "<ol>\n";
                }
                while (!$stack->isEmpty() && $stack->top() > $item->depth) {
                    $stack->pop();
                    echo "</ol></li>\n";
                }
                echo"<li class=\"sortableListsOpen\" id=\"row-".$item->id."\"><div>{$item->id}.".$item->name."</div>\n";
            }
            while ($stack->count() > 1) {
                $stack->pop();
                echo "</ol>\n</li>\n";
            }
            ?>
        </ul>
    </div>
</div>
<?php
$root_id = (int)$root->id;
$ajax_url = Url::to(['move']);
$asset_root = Yii::getAlias('@web');
$js = <<<JS
/*
    var root = {$root_id};
    var row_start_id = 0;
    var row_end_id   = 0;
    $("#w0 .table").tableDnD({
            onDragClass: "danger",
            onDropStyle: "success",
            onDrop: function(table, row) {
                var row_start_id = row.id;
                if(row_start_id == 'row_{$root_id}')
                return false;
                var row_prev_id = $('#'+row.id).prev().attr('id');
                var row_next_id = $('#'+row.id).next().attr('id');
                console.log(row_start_id + '->' +row_prev_id);
                if(row_start_id == row_prev_id)
                    return false;
                var start_id = row_start_id.substr(4);
                var prev_id   = row_prev_id.substr(4);
                var next_id  = row_next_id.substr(4);
                console.log(start_id + '->' + prev_id);
                var method = $('input[name=move-method]:checked').val()
                 $.ajax({
                    url:'{$ajax_url}',
                    data:'start_id='+start_id+'&prev_id='+prev_id+'&next_id='+next_id+'&method='+method,
                    dataType: "text",
                    method:'get',
                    success:function(data){
                            alert(data);
                    }
                });

            },
            onDragStart: function(table, row) {
                row_start_id = row.id;
                if(row_start_id == 'row_{$root_id}')
                return false;
 		    }
	    }
    );
*/
var options ={
    currElClass:'currEl',
	placeholderClass:'placeholder',
	hintClass:'hint',
	listSelector: 'ol',
	hintWrapperClass:'hintWrapper',
	//listsCss: {'background-color':'#bbffbb', 'border':'1px solid white','color':'#337ab7'},
	listsClass:'lists',
	insertZone: 20,
	scroll: 20,
	onDragStart: function(e, el)
	{
         console.log( 'onDragStart' );

	},
/*	isAllowed: function(currEl, hint, target)
	{
         console.log( 'isAllowed' );
	},*/
    onChange: function( cEl )
    {
         var cur  = cEl.attr('id');
         var prev = cEl.prev().attr('id');
         var method = curNode = targetNode = null;
         if(typeof (prev)!=='undefined'){
              targetNode = prev;
              curNode    = cur;
              method     = 'insertBefore';

         }
         var parent = cEl.parents('li').attr('id');
         //移动到某个直接结点下做为下级.
         if(typeof (parent)!=='undefined' && parent !='row-{$root_id}'){
              //如果能找到同级上面的结点
             if(typeof(prev)!='undefined'){
                  method  = 'insertAfter';
                   targetNode = prev;
             }else{
                  method  = 'appendTo';
                  targetNode = parent;

             }
             curNode = cur;
         }else if(typeof (parent)!=='undefined' && parent =='row-{$root_id}'){
             var next = cEl.next().attr('id');
             var prev = cEl.prev().attr('id');
             if(typeof (next)=='undefined'){
                var nextEl = cEl.closest('ol').next().children('li').get(0);
                //向上移动到顶级结点下面且上面是直接顶级结点
                if(typeof (nextEl)!='undefined'){
                    next = nextEl.id;
                    method  = 'insertBefore';

                }else{
                    //下面没有结点了,找上级结点
                    next = cEl.prev().attr('id');
                    method = 'insertBefore';
                }
             } else{
                console.log('here');
                method = 'insertBefore';
             }
             targetNode  = next;
             curNode = cur;
         }
         console.log( 'target='+targetNode+' curNode ='+curNode+ ' method=' +method );
         $.ajax({
            url:'{$ajax_url}',
            data:'target='+targetNode.substr(4)+'&curNode='+curNode.substr(4)+'&method='+method,
            dataType: "text",
            method:'get',
            success:function(data){
                 if(data!='1'){
                  alert(data);
                 }
            }
        });
    },
    complete: function( cEl )
    {
         console.log( 'complete' );
    },
	opener: {
		active: true,
		close: '{$asset_root}/imgs/Remove2.png',
		open: '{$asset_root}/imgs/Add2.png',

		openerCss: {
			'display': 'inline-block', // Default value
			'float': 'left', // Default value
			'width': '18px',
			'height': '18px',
			'margin-left': '-35px',
			'margin-right': '5px',
			'background-position': 'center center', // Default value
			'background-repeat': 'no-repeat' // Default value
		}
	}
}
$('#myList').sortableLists(options);

JS;

$this->registerJs($js);

?>