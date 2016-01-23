<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Node */

$this->title = Yii::t('app', 'Update') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => $site->name, 'url' => ['index','site_id'=>$site->id]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="node-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'site_id' => $model->site_id,
    ]) ?>

</div>
<?php
$js = <<<JS
    $('#node-cm_id,#node-parent_txt').attr('disabled',true);
JS;
$this->registerJs($js);
?>