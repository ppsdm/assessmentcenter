<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "assessor_test".
 *
 * @property int $id
 * @property int|null $assessorId
 * @property int|null $testId
 * @property string|null $status
 *
 * @property Assessor $assessor
 * @property Test $test
 */
class AssessorTest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assessor_test';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assessorId', 'testId'], 'integer'],
            [['status'], 'string', 'max' => 255],
            [['assessorId'], 'exist', 'skipOnError' => true, 'targetClass' => Assessor::className(), 'targetAttribute' => ['assessorId' => 'id']],
            [['testId'], 'exist', 'skipOnError' => true, 'targetClass' => Test::className(), 'targetAttribute' => ['testId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'assessorId' => Yii::t('app', 'Assessor ID'),
            'testId' => Yii::t('app', 'Test ID'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * Gets query for [[Assessor]].
     *
     * @return \yii\db\ActiveQuery|AssessorQuery
     */
    public function getAssessor()
    {
        return $this->hasOne(Assessor::className(), ['id' => 'assessorId']);
    }

    /**
     * Gets query for [[Test]].
     *
     * @return \yii\db\ActiveQuery|TestQuery
     */
    public function getTest()
    {
        return $this->hasOne(Test::className(), ['id' => 'testId']);
    }

    /**
     * {@inheritdoc}
     * @return AssessorTestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssessorTestQuery(get_called_class());
    }
}
