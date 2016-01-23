<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Node;
/* @var $this yii\web\View */
/* @var $model backend\models\Node */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $site->name, 'url' => ['index','site_id'=>$site->id]];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="node-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'site.name',
            'cm.name',
            'name',
            [
                'attribute'=>'is_real',
                'value' => Node::isReal()[$model->is_real]
            ],
            'v_nodes:ntext',
            [
                'attribute'=>'parent',
                'value' => isset($model->father)?$model->father->name:''
            ],
            'slug',
            'workflow.name',
            'tpl_index',
            'tpl_detail',
            [
                'attribute'=>'status',
                'value' => Node::nodeStatus()[$model->status],
            ],
            'seo_title',
            'seo_keyword',
            'seo_description',
        ],
    ]) ?>

</div>
