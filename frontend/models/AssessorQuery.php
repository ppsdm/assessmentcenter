<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[Assessor]].
 *
 * @see Assessor
 */
class AssessorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Assessor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Assessor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
