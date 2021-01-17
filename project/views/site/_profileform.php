<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model project\models\ProjectUser */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
echo Html::a('Taosync', ['site/taosync'], ['class' => 'btn btn-primary'])
?>
<div class="project-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($taomodel, 'user_uri')->textInput() ?>
<hr/>
    <?= $form->field($model, 'first_name')->textInput()->label('Nama Depan') ?>
    <?= $form->field($model, 'last_name')->textInput()->label('Nama Belakang') ?>
    <?= $form->field($model, 'gender')->textInput()->label('Jenis Kelamin') ?>
    <?= $form->field($model, 'religion')->textInput()->label('Agama') ?>
    <?= $form->field($profilecontact, 'address')->textArea()->label('Alamat') ?>
    <?= $form->field($profileext, 'identity_no')->textInput()->label('KTP') ?>
    <?= $form->field($profileext, 'last_education')->textInput()->label('Pendidikan Terakhir') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
