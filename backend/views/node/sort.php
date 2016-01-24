<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Node;
//use backend\assets\TableDndAsset;
use backend\assets\SortableListAsset;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

SortableListAsset::register($this);
$this->title = Yii::t('app', 'Nodes');
$this->params['breadcrumbs'][] = ['label' => $site->name, 'url' => ['index','site_id'=>$site->id]];
$this->params['breadcrumbs'][] = $this->title;
$children =  $root->children(1)->all();
//d($children);
function displayChild($node){
    $html = '<li class="sortableListsOpen" id="row-'.$node->id.'"><div>'.$node->name.'</div>';
    $children = $node->children(1)->all();
    if(isset($children)){
        $html .='<ul>';
        foreach($children as $child){
            $html .=displayChild($child);
        }
        $html .='</ul>';
    }
    $html .="</li>";

    return $html;
}
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
            // echo  displayChild($root);
/*            $stack = new SplStack();
            $stack->push($list[0]->depth);
          //  echo '<ul id="myList" class="col-lg-8">';


            foreach($list as $k=> $item)
            {
                if ($item->depth > $stack->top()) {
                    $stack->push($item->depth);
                    echo "<li class=\"sortableListsOpen\">".$item->name."<ul>";
                }
                while (!$stack->isEmpty() && $stack->top() > $item->depth) {
                    $stack->pop();
                     echo "<li class=\"sortableListsOpen\">".$item->name."</li>";
                    echo "</ul></li>";
                }
            }*/
           // echo '</ul>';
            $depth = 0;
            echo '<ul>';
            foreach($list as $index => $item){
                if ($item->depth > $depth) {
                    while ($item->depth > $depth) {
                        echo '<ul>';
                        echo '<li>';
                        $depth++;
                    }
                } else if ($item->depth < $depth) {
                    while ($item->depth < $depth) {
                        echo '</li>';
                        echo '</ul>';
                        $depth--;
                    }
                } else if ($item->depth === $depth && $index !== 0) {
                    echo '</li>';
                    echo '<li>';
                }
                echo $item->name;

                $depth = $item['depth'];
            }
            while ($depth-- >= 0) {
                echo '</li>';
                echo '</ul>';
            }
            ?>
        </ul>
    </div>
</div>
<?php
$root_id = (int)$root->id;
$ajax_url = Url::to(['move']);
$root = Yii::getAlias('@web');
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
	//insertZone: 40,
	scroll: 20,
    onChange: function( cEl )
    {
        console.log(cEl);
        console.log( 'onChange' );
    },
    complete: function( cEl )
    {
        console.log(cEl);
        console.log( 'complete' );
    },
	opener: {
		active: true,
		close: '{$root}/imgs/Remove2.png',
		open: '{$root}/imgs/Add2.png',

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