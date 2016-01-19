<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Cm */

$this->title = Yii::t('app','Update Cm: ') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Content Model'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app','Update');
?>
<div class="cm-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?php
$js = <<<JS
$('#site_txt,#cm-tab_index,#cm-tab').attr('disabled',true);
JS;
$this->registerJs($js);
?>