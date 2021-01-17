<?php

namespace project\models;

/**
 * This is the ActiveQuery class for [[ProjectProfileData]].
 *
 * @see ProjectProfileData
 */
class ProjectProfileDataQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProjectProfileData[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProjectProfileData|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
