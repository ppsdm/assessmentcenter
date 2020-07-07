<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "videochat".
 *
 * @property int $id
 * @property string|null $roomname
 * @property string|null $roomId
 * @property string|null $start_time
 * @property string|null $end_time
 * @property int|null $duration
 * @property string|null $type
 * @property string|null $options
 * @property string|null $status
 */
class Videochat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'videochat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_time', 'end_time'], 'safe'],
            [['duration'], 'integer'],
            [['options'], 'string'],
            [['roomname', 'roomId', 'type', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'roomname' => Yii::t('app', 'Roomname'),
            'roomId' => Yii::t('app', 'Room ID'),
            'start_time' => Yii::t('app', 'Start Time'),
            'end_time' => Yii::t('app', 'End Time'),
            'duration' => Yii::t('app', 'Duration'),
            'type' => Yii::t('app', 'Type'),
            'options' => Yii::t('app', 'Options'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return VideochatQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VideochatQuery(get_called_class());
    }
}
