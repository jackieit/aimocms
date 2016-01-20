<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Cm */

$this->title = Yii::t('app','Update') . ' ' . $model->var;
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

JS;
$this->registerJs($js);
?>