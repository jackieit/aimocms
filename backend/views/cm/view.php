<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Cm;
/* @var $this yii\web\View */
/* @var $model common\models\Cm */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Content Model'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$tab_index = Cm::$TAB_INDEX;
$is_inner  = cm::IS_INNER();
?>
<div class="cm-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    if(!$model->is_inner):
    ?>
    <p>
        <?= Html::a(Yii::t('app','Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app','Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php endif;?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'tab',
            [
                'attribute'=>'is_inner',
                'value'    =>  $is_inner[$model->is_inner]
            ],
            'site.name',
            [
                'attribute'=>'tab_index',
                'value'    =>  $tab_index[$model->tab_index]
            ],
        ],
    ]) ?>

</div>
