<?php

namespace project\models;

use Yii;

/**
 * This is the model class for table "project_preassigned".
 *
 * @property int $id
 * @property int|null $projectId
 * @property string|null $username
 *
 * @property Project $project
 */
class ProjectPreassigned extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_preassigned';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['projectId'], 'integer'],
            [['username'], 'string', 'max' => 255],
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
            'username' => Yii::t('app', 'Username'),
        ];
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
     * @return ProjectPreassignedQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectPreassignedQuery(get_called_class());
    }
}
