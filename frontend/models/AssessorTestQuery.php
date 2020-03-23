<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[AssessorTest]].
 *
 * @see AssessorTest
 */
class AssessorTestQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AssessorTest[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AssessorTest|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
