<?php

namespace project\models;

use Yii;

/**
 * This is the model class for table "project_group".
 *
 * @property int $id
 * @property int|null $project_id
 * @property int|null $tao_group_id
 *
 * @property Project $project
 * @property TaoGroup $taoGroup
 */
class ProjectGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'tao_group_id'], 'integer'],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['tao_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaoGroup::className(), 'targetAttribute' => ['tao_group_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'project_id' => Yii::t('app', 'Project ID'),
            'tao_group_id' => Yii::t('app', 'Tao Group ID'),
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
     * Gets query for [[TaoGroup]].
     *
     * @return \yii\db\ActiveQuery|TaoGroupQuery
     */
    public function getTaoGroup()
    {
        return $this->hasOne(TaoGroup::className(), ['id' => 'tao_group_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProjectGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectGroupQuery(get_called_class());
    }
}
