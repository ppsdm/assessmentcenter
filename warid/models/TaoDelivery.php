<?php

namespace warid\models;

use Yii;

/**
 * This is the model class for table "tao_delivery".
 *
 * @property int $id
 * @property string|null $delivery_name
 * @property string|null $delivery_uri
 * @property string|null $status
 */
class TaoDelivery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tao_delivery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['delivery_name', 'delivery_uri', 'status'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'delivery_name' => Yii::t('app', 'Delivery Name'),
            'delivery_uri' => Yii::t('app', 'Delivery Uri'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return TaoDeliveryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaoDeliveryQuery(get_called_class());
    }
}
