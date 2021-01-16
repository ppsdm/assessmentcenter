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
    <?= $form->field($model, 'first_name')->textInput() ?>
    <?= $form->field($model, 'last_name')->textInput() ?>
    <?= $form->field($model, 'gender')->textInput() ?>
    <?= $form->field($model, 'religion')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
