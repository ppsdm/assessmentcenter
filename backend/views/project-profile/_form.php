<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProjectProfile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'projectId')->textInput() ?>

    <?= $form->field($model, 'profileId')->textInput() ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
