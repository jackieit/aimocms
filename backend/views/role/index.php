<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Auth Roles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-role-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Auth Role'), ['create'], ['class' => 'btn btn-success','data-pjax'=>0]) ?>
        <?= Html::a(Yii::t('app', 'List Auth Category'), ['category-list'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            [
                'attribute'=>'authCategory.name',
                'label' => Yii::t('app','Category Name'),
            ],
            'name',
            'description',
            //'controllers:ntext',
            //'actions:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
