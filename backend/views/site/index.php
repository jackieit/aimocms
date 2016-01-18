<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sites');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Site'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'template',
            [
                'attribute'=>'is_publish',
                'value'    => function($model){

                    return $model->is_publish ==1?Yii::t('app','Yes'):Yii::t('app','No');
                }
            ],
            'path',
            // 'dsn',
            // 'url:url',
            // 'res_path',
            // 'res_url:url',
            // 'page_404',
            // 'beian',
            // 'seo_title',
            // 'seo_keyword',
            // 'seo_description',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
