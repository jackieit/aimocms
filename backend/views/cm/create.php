<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Cm */

$this->title = Yii::t('app','Create Cm');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Content Model'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$model->is_inner = '2';
?>
<div class="cm-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
