<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Videochat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="videochat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'roomname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'roomId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_time')->textInput() ?>

    <?= $form->field($model, 'end_time')->textInput() ?>



    <?php
    $types = ['group' => 'group', 'group-small' => 'small / p2p'];
    echo $form->field($model, 'type')->dropDownList(
        $types,
        ['prompt'=>'Select...']);
        ?>

    <?= $form->field($model, 'options')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
