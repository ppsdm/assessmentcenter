<?php

namespace project\models;

/**
 * This is the ActiveQuery class for [[ProjectTaouser]].
 *
 * @see ProjectTaouser
 */
class ProjectTaouserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProjectTaouser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProjectTaouser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
