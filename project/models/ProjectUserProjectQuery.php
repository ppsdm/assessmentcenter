<?php

namespace project\models;

/**
 * This is the ActiveQuery class for [[ProjectUserProject]].
 *
 * @see ProjectUserProject
 */
class ProjectUserProjectQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProjectUserProject[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProjectUserProject|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
