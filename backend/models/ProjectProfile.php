<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "project_profile".
 *
 * @property int $id
 * @property int $projectId
 * @property int $profileId
 * @property string|null $status
 *
 * @property Profile $profile
 * @property Project $project
 */
class ProjectProfile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['projectId', 'profileId'], 'required'],
            [['projectId', 'profileId'], 'integer'],
            [['status'], 'string', 'max' => 255],
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
            'status' => Yii::t('app', 'Status'),
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
     * @return ProjectProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectProfileQuery(get_called_class());
    }
}
