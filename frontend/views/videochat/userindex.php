<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\VideochatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Available User Rooms');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="videochat-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'roomname',
            'roomId',
//            'start_time',
//            'end_time',
//            'type',
        'duration',
            //'options:ntext',
            'status',
//            [
//                'label' => 'Recordings',
//                'format' => 'raw',
//                'value' => function($model) {
//                    return Html::a('Recordings', ['videochat/recordings', 'id' => $model->id]);
//                }
//            ],
//            [
//  'label' => 'Create',
//                'format' => 'raw',
//                'value' => function($model) {
//        return Html::a('Create', ['videochat/createroom', 'id' => $model->id]);
//                }
//],
            [
                'label' => 'Join',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a('Join', ['videochat/userjoin', 'id' => $model->id, 'identity' => 'admin']);
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
