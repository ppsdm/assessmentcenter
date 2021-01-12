<?php

namespace project\models;

use frontend\models\Profile;
use Yii;

/**
 * This is the model class for table "project_user_profile".
 *
 * @property int $id
 * @property int|null $projectUserId
 * @property int|null $profileId
 *
 * @property Profile $profile
 * @property ProjectUser $projectUser
 */
class ProjectUserProfile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_user_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['projectUserId', 'profileId'], 'integer'],
            [['profileId'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profileId' => 'id']],
            [['projectUserId'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectUser::className(), 'targetAttribute' => ['projectUserId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'projectUserId' => Yii::t('app', 'Project User ID'),
            'profileId' => Yii::t('app', 'Profile ID'),
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
     * Gets query for [[ProjectUser]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getProjectUser()
    {
        return $this->hasOne(ProjectUser::className(), ['id' => 'projectUserId']);
    }

    /**
     * {@inheritdoc}
     * @return ProjectUserProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectUserProfileQuery(get_called_class());
    }
}
