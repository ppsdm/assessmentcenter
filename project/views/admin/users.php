<?php


use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Project User');
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
            'username',
            'email',
            [
                'label' => 'change tao group',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Html::a(Html::encode("View Tao Groups"),'taogroups');
                },
            ],
            [
                'label' => 'change password',
            ],

        [


                'class' => 'yii\grid\ActionColumn',

    'template' => '{userview} {info}',

    'buttons' => [
                    'userview' => function ($url, $model) {

            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [

                        'title' => Yii::t('app', 'View'),

            ]);

        },
        'info' => function ($url, $model) {

            return Html::a('<span class="glyphicon glyphicon-info-sign"></span>', $url, [

                        'title' => Yii::t('app', 'Info'),

            ]);

        }

    ],



        ],
            //  ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
