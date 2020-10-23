<?php

namespace project\models;

use Yii;

/**
 * This is the model class for table "tao_user".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $user_uri
 * @property string|null $status
 * @property string|null $first_name
 * @property string|null $last_name
 *
 * @property TaoUserGroup[] $taoUserGroups
 * @property TaoGroup[] $taoGroups
 */
class TaoUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $name;
    public $username;
    public $password;
    public static function tableName()
    {
        return 'taouser';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['id'], 'required'],
            [['password'], 'required'],
            [['username'], 'email'],
            [['id', 'user_id'], 'integer'],
            [['user_uri', 'status', 'first_name', 'last_name'], 'string', 'max' => 255],
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
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
        ];
    }

    /**
     * Gets query for [[TaoUserGroups]].
     *
     * @return \yii\db\ActiveQuery|TaoUserGroupQuery
     */
    public function getTaoUserGroups()
    {
        return $this->hasMany(TaoUserGroup::className(), ['tao_user_id' => 'id']);
    }

    /**
     * Gets query for [[TaoGroups]].
     *
     * @return \yii\db\ActiveQuery|TaoGroupQuery
     */
    public function getTaoGroups()
    {
        return $this->hasMany(TaoGroup::className(), ['id' => 'tao_group_id'])->viaTable('tao_user_group', ['tao_user_id' => 'id']);
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
