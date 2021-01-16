<?php

namespace project\models;

use Yii;

/**
 * This is the model class for table "project_taouser".
 *
 * @property int $id
 * @property int|null $project_user_id
 * @property string|null $user_uri
 * @property string|null $username
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $status
 *
 * @property TaoUserGroup[] $taoUserGroups
 * @property TaoGroup[] $taoGroups
 */
class ProjectTaouser extends \yii\db\ActiveRecord
{

    public $username;
    public $password;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_taouser';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_user_id'], 'integer'],
            [['user_uri', 'username', 'first_name', 'last_name', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'project_user_id' => Yii::t('app', 'Project User ID'),
            'user_uri' => Yii::t('app', 'User Uri'),
            'username' => Yii::t('app', 'Username'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'status' => Yii::t('app', 'Status'),
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
     * @return ProjectTaouserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectTaouserQuery(get_called_class());
    }
}
