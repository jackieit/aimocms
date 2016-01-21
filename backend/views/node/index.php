<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Nodes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="node-index">


    <p>
        <?= Html::a(Yii::t('app', 'Create Node'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'site_id',
            'cm_id',
            'name',
            'is_real',
            // 'v_nodes:ntext',
            // 'parent',
            // 'slug',
            // 'workflow',
            // 'tpl_index',
            // 'tpl_detail',
            // 'status',
            // 'seo_title',
            // 'seo_keyword',
            // 'seo_description',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
