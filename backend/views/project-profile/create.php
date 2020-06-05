<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ProjectProfile */

$this->title = Yii::t('app', 'Create Project Profile');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Project Profiles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-profile-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
