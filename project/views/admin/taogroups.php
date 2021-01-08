<?php


use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tao Groups');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'group_name',
            'group_uri',
            [
                'label' => 'change tao group',
            ],
            [
                'label' => 'change password',
            ],
            [
                'label' => 'view result',
            ],

            //  ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
