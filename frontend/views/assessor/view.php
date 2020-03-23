<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Assessor */

$this->title = $model->project->project_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Assessors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="assessor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
<!--disini tadinya trempat button udpate dan delete-->
    </p>

    <?= GridView::widget([
        'dataProvider' => $testProvider,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'testId',
            //'profileId',
            'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>



</div>
