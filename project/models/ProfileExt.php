<?php

namespace project\models;

use frontend\models\Profile;
use Yii;

/**
 * This is the model class for table "profile_ext".
 *
 * @property int $id
 * @property int $profileId
 * @property string|null $identity_no
 * @property string|null $identity_type
 * @property string|null $last_education
 *
 * @property Profile $profile
 */
class ProfileExt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile_ext';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profileId'], 'required'],
            [['profileId'], 'integer'],
            [['identity_no', 'identity_type', 'last_education'], 'string', 'max' => 255],
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
            'identity_no' => Yii::t('app', 'Identity No'),
            'identity_type' => Yii::t('app', 'Identity Type'),
            'last_education' => Yii::t('app', 'Last Education'),
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
     * @return ProfileExtQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProfileExtQuery(get_called_class());
    }
}
