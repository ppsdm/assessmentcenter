<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Assessor */

$this->title = Yii::t('app', 'Create Assessor');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Assessors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assessor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
