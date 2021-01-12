<?php

namespace project\models;

/**
 * This is the ActiveQuery class for [[ProjectUserProfile]].
 *
 * @see ProjectUserProfile
 */
class ProjectUserProfileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProjectUserProfile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProjectUserProfile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
