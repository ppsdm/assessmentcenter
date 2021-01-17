<?php

namespace project\models;

use frontend\models\Profile;
use Yii;

/**
 * This is the model class for table "project_profile_data".
 *
 * @property int $id
 * @property int|null $projectId
 * @property int|null $profileId
 * @property string|null $prospek
 * @property string|null $tempat_tes
 * @property string|null $tanggal_tes
 *
 * @property Profile $profile
 * @property Project $project
 */
class ProjectProfileData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_profile_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['projectId', 'profileId'], 'integer'],
            [['tanggal_tes'], 'safe'],
            [['prospek', 'tempat_tes'], 'string', 'max' => 255],
            [['profileId'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profileId' => 'id']],
            [['projectId'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['projectId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'projectId' => Yii::t('app', 'Project ID'),
            'profileId' => Yii::t('app', 'Profile ID'),
            'prospek' => Yii::t('app', 'Prospek'),
            'tempat_tes' => Yii::t('app', 'Tempat Tes'),
            'tanggal_tes' => Yii::t('app', 'Tanggal Tes'),
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
     * Gets query for [[Project]].
     *
     * @return \yii\db\ActiveQuery|ProjectQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'projectId']);
    }

    /**
     * {@inheritdoc}
     * @return ProjectProfileDataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectProfileDataQuery(get_called_class());
    }
}
