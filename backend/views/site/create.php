<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Site */

$this->title = Yii::t('app', 'Create Site');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
