<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "results_storage".
 *
 * @property string $result_id
 * @property string|null $test_taker
 * @property string|null $delivery
 */
class ResultsStorage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'results_storage';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('taodb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['result_id'], 'required'],
            [['result_id', 'test_taker', 'delivery'], 'string', 'max' => 255],
            [['result_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'result_id' => Yii::t('app', 'Result ID'),
            'test_taker' => Yii::t('app', 'Test Taker'),
            'delivery' => Yii::t('app', 'Delivery'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ResultsStorageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResultsStorageQuery(get_called_class());
    }
}
