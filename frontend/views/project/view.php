<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Project */

$this->title = $model->project_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <p>
        <?php
//
//
//        echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
//        echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
//            'class' => 'btn btn-danger',
//            'data' => [
//                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
//                'method' => 'post',
//            ],
//        ]);

        ?>
    </p>

    <?php

//    echo DetailView::widget([
//        'model' => $model,
//        'attributes' => [
//            'id',
//            'project_name',
//        ],
//    ]);

    ?>
<h1>Daftar Test</h1>
    <?= GridView::widget([
        'dataProvider' => $testProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
         //   'status',
[
        'label' => 'Status',
        'attribute' => 'status',
        'format' => 'raw',
        'value' => function($data) {
if ($data->status == 'invited') {
    return Html::a(Yii::t('app', 'Start Test'), ['test/start', 'id'=>$data->id], ['class' => 'btn btn-success']);
} else if ($data->status == 'working') {
    return Html::a(Yii::t('app', 'Continue Test'), ['test/start', 'id'=>$data->id], ['class' => 'btn btn-warning']);
} else if ($data->status == 'completed') {

}

        },
],
['label' => 'Report'],

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>



</div>
