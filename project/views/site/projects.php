<?php


use project\models\ProjectGroup;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Projects');
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
                'label' => 'Project Name',
                'value' => function ($model) {
                    return $model->project->project_name;
                }
            ],
            [
                'label' => 'Tao Groups',
                'value' => function ($model) {
        $id = $model->project->id;
        $groups = ProjectGroup::find()->andWhere(['project_id' => $id])->All();
        $groupstring = '';
        foreach ($groups as $group) {
            $groupstring = $groupstring . ", " . $group->taoGroup->group_name;
        }
                    return substr($groupstring, 2);
                }
            ],
//            [
//                'label' => 'view result',
//            ],

            //  ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
