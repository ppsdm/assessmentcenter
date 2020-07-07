<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Videochat */

$this->title = Yii::t('app', 'Create Videochat');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Videochats'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="videochat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
