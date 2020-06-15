<?php
/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\helpers\Html;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        // Simple columns defined by the data contained in $dataProvider.
        // Data from the model's column will be used.
        'result_id',
'test_taker', 'delivery',
        [
            'label'=>'result',
            'format' => 'raw',
            'value'=>function ($data) {
//                return Html::a(['warid/nilaiwarid']);
                return '<a href="nilaiwarid?testtakerId=' . urlencode( $data->test_taker) .'&deliveryId='.urlencode($data->delivery).'">RESULT</a>';
//                return;
            },
        ],
    ],
]);



?>