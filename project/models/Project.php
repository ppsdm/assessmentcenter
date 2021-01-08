<?php

namespace project\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string|null $project_name
 *
 * @property Assessor[] $assessors
 * @property ProjectGroup[] $projectGroups
 * @property ProjectProfile[] $projectProfiles
 * @property ProjectUserProject[] $projectUserProjects
 * @property Test[] $tests
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'project_name' => Yii::t('app', 'Project Name'),
        ];
    }

    /**
     * Gets query for [[Assessors]].
     *
     * @return \yii\db\ActiveQuery|AssessorQuery
     */
    public function getAssessors()
    {
        return $this->hasMany(Assessor::className(), ['projectId' => 'id']);
    }

    /**
     * Gets query for [[ProjectGroups]].
     *
     * @return \yii\db\ActiveQuery|ProjectGroupQuery
     */
    public function getProjectGroups()
    {
        return $this->hasMany(ProjectGroup::className(), ['project_id' => 'id']);
    }

    /**
     * Gets query for [[ProjectProfiles]].
     *
     * @return \yii\db\ActiveQuery|ProjectProfileQuery
     */
    public function getProjectProfiles()
    {
        return $this->hasMany(ProjectProfile::className(), ['projectId' => 'id']);
    }

    /**
     * Gets query for [[ProjectUserProjects]].
     *
     * @return \yii\db\ActiveQuery|ProjectUserProjectQuery
     */
    public function getProjectUserProjects()
    {
        return $this->hasMany(ProjectUserProject::className(), ['project_id' => 'id']);
    }

    /**
     * Gets query for [[Tests]].
     *
     * @return \yii\db\ActiveQuery|TestQuery
     */
    public function getTests()
    {
        return $this->hasMany(Test::className(), ['projectId' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectQuery(get_called_class());
    }
}
