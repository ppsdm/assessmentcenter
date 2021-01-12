<?php

namespace project\models;

use Yii;

/**
 * This is the model class for table "tao_group".
 *
 * @property int $id
 * @property string|null $group_name
 * @property string|null $group_uri
 * @property string|null $status
 *
 * @property TaoGroupDelivery[] $taoGroupDeliveries
 * @property TaoDelivery[] $taoDeliveries
 * @property TaoUserGroup[] $taoUserGroups
 * @property Taouser[] $taoUsers
 */
class TaoGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tao_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_name', 'group_uri', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'group_name' => Yii::t('app', 'Group Name'),
            'group_uri' => Yii::t('app', 'Group Uri'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * Gets query for [[TaoGroupDeliveries]].
     *
     * @return \yii\db\ActiveQuery|TaoGroupDeliveryQuery
     */
    public function getTaoGroupDeliveries()
    {
        return $this->hasMany(TaoGroupDelivery::className(), ['tao_group_id' => 'id']);
    }

    /**
     * Gets query for [[TaoDeliveries]].
     *
     * @return \yii\db\ActiveQuery|TaoDeliveryQuery
     */
    public function getTaoDeliveries()
    {
        return $this->hasMany(TaoDelivery::className(), ['id' => 'tao_delivery_id'])->viaTable('tao_group_delivery', ['tao_group_id' => 'id']);
    }

    /**
     * Gets query for [[TaoUserGroups]].
     *
     * @return \yii\db\ActiveQuery|TaoUserGroupQuery
     */
    public function getTaoUserGroups()
    {
        return $this->hasMany(TaoUserGroup::className(), ['tao_group_id' => 'id']);
    }

    /**
     * Gets query for [[TaoUsers]].
     *
     * @return \yii\db\ActiveQuery|TaoUserQuery
     */
    public function getTaoUsers()
    {
        return $this->hasMany(ProjectTaouser::className(), ['id' => 'tao_user_id'])->viaTable('tao_user_group', ['tao_group_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return TaoGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaoGroupQuery(get_called_class());
    }
}
