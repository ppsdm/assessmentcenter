<?php

namespace project\models;

use frontend\models\Profile;
use Yii;

/**
 * This is the model class for table "profile_contact".
 *
 * @property int $id
 * @property int|null $profileId
 * @property string|null $address
 *
 * @property Profile $profile
 */
class ProfileContact extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile_contact';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profileId'], 'integer'],
            [['address'], 'string'],
            [['profileId'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profileId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'profileId' => Yii::t('app', 'Profile ID'),
            'address' => Yii::t('app', 'Address'),
        ];
    }

    /**
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery|ProfileQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profileId']);
    }

    /**
     * {@inheritdoc}
     * @return ProfileContactQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProfileContactQuery(get_called_class());
    }
}
