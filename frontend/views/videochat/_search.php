<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\VideochatSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="videochat-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'roomname') ?>

    <?= $form->field($model, 'roomId') ?>

    <?= $form->field($model, 'start_time') ?>

    <?= $form->field($model, 'end_time') ?>

    <?php // echo $form->field($model, 'duration') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'options') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
