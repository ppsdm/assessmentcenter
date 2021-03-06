<?php


use project\models\ProjectGroup;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Groups');
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

//            'id',
//            'project_name',
            [
                'label' => 'From Project',
                'value' => function ($model) {
                    return $model->project->project_name;
                }
            ],
            [
                'label' => 'Tao Groups',
                'value' => function ($model) {
return $model->taoGroup->group_name;
                }
            ],
            [
                'label' => 'Tao Group URI',
                'value' => function ($model) {
                    return $model->taoGroup->group_uri;
                }
            ],
            [
                'label' => 'Sync?',
                'value' => function ($model) use ($taogroups) {
        if (in_array($model->taoGroup->group_uri, $taogroups)) {
            return 'yes';
        } else {
            return 'no';
        }

                }
            ],

            //  ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>


</div>
