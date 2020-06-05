<?php

namespace warid\models;

use Yii;

/**
 * This is the model class for table "scale_ref".
 *
 * @property string $scale_name
 * @property int $unscaled
 * @property int|null $scaled
 */
class ScaleRef extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'scale_ref';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('coredb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['scale_name', 'unscaled'], 'required'],
            [['unscaled', 'scaled'], 'integer'],
            [['scale_name'], 'string', 'max' => 255],
            [['scale_name', 'unscaled'], 'unique', 'targetAttribute' => ['scale_name', 'unscaled']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'scale_name' => Yii::t('app', 'Scale Name'),
            'unscaled' => Yii::t('app', 'Unscaled'),
            'scaled' => Yii::t('app', 'Scaled'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ScaleRefQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ScaleRefQuery(get_called_class());
    }
}
