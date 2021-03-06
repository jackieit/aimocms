<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contents');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Content'), ['create'], ['class' => 'btn btn-success','data-pjax'=>0]) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'color',
            'author',
            'from',
            // 'photo',
            // 'intro',
            // 'content:ntext',
            // 'seo_title',
            // 'seo_keyword',
            // 'seo_description',
            // 'tpl_detail',
            // 'file_name',
            // 'slug',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
