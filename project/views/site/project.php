<?php


use kartik\datetime\DateTimePicker;
use project\models\ProjectGroup;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Additional Info');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="project-user-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($profiledata, 'prospek')->textInput() ?>
        <?= $form->field($profiledata, 'tempat_tes')->textInput() ?>


        <?php


        echo '<label class="control-label">Tanggal Tes </label>';
        echo DateTimePicker::widget([
            'model' => $profiledata,
            'attribute' => 'tanggal_tes',
            //'language' => 'ru',
            'pluginOptions' => [
                'todayHighlight' => true,
                'todayBtn' => true,
                'autoclose' => true,
                'format' => 'yyyy-mm-dd hh:ii'
            ]
        ]);
echo '</br>';
        ?>


        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
