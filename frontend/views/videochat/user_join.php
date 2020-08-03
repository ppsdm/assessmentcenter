<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Videochat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="videochat-form">

    <?php $form = ActiveForm::begin(); ?>
<p>

    <?= Html::label('Name', 'name', ['class' => '']) ?>
    <?=Html::input('text','name','',['class'=>'form-control'])?>
</p>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Join'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
