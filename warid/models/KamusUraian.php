<?php

namespace warid\models;

use Yii;

/**
 * This is the model class for table "kamus_uraian".
 *
 * @property string $aspek
 * @property string $level
 * @property string $varian
 * @property string|null $description
 */
class KamusUraian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kamus_uraian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aspek', 'level', 'varian'], 'required'],
            [['description'], 'string'],
            [['aspek', 'level', 'varian'], 'string', 'max' => 255],
            [['aspek', 'level', 'varian'], 'unique', 'targetAttribute' => ['aspek', 'level', 'varian']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'aspek' => Yii::t('app', 'Aspek'),
            'level' => Yii::t('app', 'Level'),
            'varian' => Yii::t('app', 'Varian'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return KamusUraianQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KamusUraianQuery(get_called_class());
    }
}
