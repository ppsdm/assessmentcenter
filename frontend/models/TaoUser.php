<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tao_user".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $user_uri
 * @property string|null $status
 *
 * @property User $user
 */
class TaoUser extends \yii\db\ActiveRecord
{

    public $name;
    public $username;
    public $password;


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
            [['password'], 'required'],
            [['id', 'user_id'], 'integer'],
            [['user_uri', 'status'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['username'], 'email'],
//            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
