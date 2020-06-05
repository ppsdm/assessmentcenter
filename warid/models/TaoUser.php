<?php

namespace warid\models;

use Yii;

/**
 * This is the model class for table "tao_user".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $user_uri
 * @property string|null $status
 */
class TaoUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tao_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'user_id'], 'integer'],
            [['user_uri', 'status'], 'string', 'max' => 255],
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
            'user_id' => Yii::t('app', 'User ID'),
            'user_uri' => Yii::t('app', 'User Uri'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return TaoUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaoUserQuery(get_called_class());
    }
}
