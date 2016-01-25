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
var options ={
    currElClass:'currEl',
	placeholderClass:'placeholder',
	hintClass:'hint',
	listSelector: 'ol',
	hintWrapperClass:'hintWrapper',
	listsClass:'lists',
	insertZone: 20,
	scroll: 20,
	onDragStart: function(e, el)
	{
         //console.log( 'onDragStart' );

	},
/*	isAllowed: function(currEl, hint, target)
	{
         console.log( 'isAllowed' );
	},*/
    onChange: function( cEl )
    {
         var cur  = cEl.attr('id');

         var method = curNode = targetNode = null;


         var prev = cEl.prev().attr('id');
         if(typeof (prev)=='undefined'){
            try{
               prev = cEl.closest('ol').prev().children('li').get(0).id;
            }catch(e){

            }
         }
         var next = cEl.next().attr('id');
          if(typeof (next)=='undefined'){
            try{
                next = cEl.closest('ol').next().children('li').get(0).id;
            }catch(e){

            }
         }
         var parent = cEl.parents('li').attr('id');
         if(typeof (prev) !='undefined'){
            method = 'insertAfter';
            targetNode = prev;
         }else if(typeof (next) !='undefined'){
            targetNode = next;
            method = 'insertBefore';
         }else if(typeof(parent)!='undefined'){
            targetNode = parent;
            method = 'appendTo';
         }
         curNode = cur;
         //console.log( 'target='+targetNode+' curNode ='+curNode+ ' method=' +method );
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
        // console.log( 'complete' );
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