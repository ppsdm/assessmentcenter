<?php

namespace project\models;

use Yii;

/**
 * This is the model class for table "project_user_project".
 *
 * @property int $id
 * @property int|null $project_user_id
 * @property int|null $project_id
 *
 * @property Project $project
 * @property ProjectUser $projectUser
 */
class ProjectUserProject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_user_project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_user_id', 'project_id'], 'integer'],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['project_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectUser::className(), 'targetAttribute' => ['project_user_id' => 'id']],
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
            'project_id' => Yii::t('app', 'Project ID'),
        ];
    }

    /**
     * Gets query for [[Project]].
     *
     * @return \yii\db\ActiveQuery|ProjectQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * Gets query for [[ProjectUser]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getProjectUser()
    {
        return $this->hasOne(ProjectUser::className(), ['id' => 'project_user_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProjectUserProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectUserProjectQuery(get_called_class());
    }
}
