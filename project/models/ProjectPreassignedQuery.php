<?php

namespace project\models;

/**
 * This is the ActiveQuery class for [[ProjectPreassigned]].
 *
 * @see ProjectPreassigned
 */
class ProjectPreassignedQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProjectPreassigned[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProjectPreassigned|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
