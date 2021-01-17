<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $full_name
 * @property string|null $gender
 * @property string|null $religion
 * @property string|null $birthday
 * @property string|null $birthplace
 *
 * @property Assessor[] $assessors
 * @property ProfileContact[] $profileContacts
 * @property ProfileExt[] $profileExts
 * @property ProfileLk[] $profileLks
 * @property ProjectProfile[] $projectProfiles
 * @property ProjectUserProfile[] $projectUserProfiles
 * @property Test[] $tests
 * @property UserProfile[] $userProfiles
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['birthday'], 'safe'],
            [['first_name', 'last_name', 'full_name', 'gender', 'religion', 'birthplace'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'full_name' => Yii::t('app', 'Full Name'),
            'gender' => Yii::t('app', 'Gender'),
            'religion' => Yii::t('app', 'Religion'),
            'birthday' => Yii::t('app', 'Birthday'),
            'birthplace' => Yii::t('app', 'Birthplace'),
        ];
    }

    /**
     * Gets query for [[Assessors]].
     *
     * @return \yii\db\ActiveQuery|AssessorQuery
     */
    public function getAssessors()
    {
        return $this->hasMany(Assessor::className(), ['profileId' => 'id']);
    }

    /**
     * Gets query for [[ProfileContacts]].
     *
     * @return \yii\db\ActiveQuery|ProfileContactQuery
     */
    public function getProfileContacts()
    {
        return $this->hasMany(ProfileContact::className(), ['profileId' => 'id']);
    }

    /**
     * Gets query for [[ProfileExts]].
     *
     * @return \yii\db\ActiveQuery|ProfileExtQuery
     */
    public function getProfileExts()
    {
        return $this->hasMany(ProfileExt::className(), ['profileId' => 'id']);
    }

    /**
     * Gets query for [[ProfileLks]].
     *
     * @return \yii\db\ActiveQuery|ProfileLkQuery
     */
    public function getProfileLks()
    {
        return $this->hasMany(ProfileLk::className(), ['profileId' => 'id']);
    }

    /**
     * Gets query for [[ProjectProfiles]].
     *
     * @return \yii\db\ActiveQuery|ProjectProfileQuery
     */
    public function getProjectProfiles()
    {
        return $this->hasMany(ProjectProfile::className(), ['profileId' => 'id']);
    }

    /**
     * Gets query for [[ProjectUserProfiles]].
     *
     * @return \yii\db\ActiveQuery|ProjectUserProfileQuery
     */
    public function getProjectUserProfiles()
    {
        return $this->hasMany(ProjectUserProfile::className(), ['profileId' => 'id']);
    }

    /**
     * Gets query for [[Tests]].
     *
     * @return \yii\db\ActiveQuery|TestQuery
     */
    public function getTests()
    {
        return $this->hasMany(Test::className(), ['profileId' => 'id']);
    }

    /**
     * Gets query for [[UserProfiles]].
     *
     * @return \yii\db\ActiveQuery|UserProfileQuery
     */
    public function getUserProfiles()
    {
        return $this->hasMany(UserProfile::className(), ['profileId' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProfileQuery(get_called_class());
    }
}
