<?php

namespace project\models;

/**
 * This is the ActiveQuery class for [[TaoGroup]].
 *
 * @see TaoGroup
 */
class TaoGroupQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TaoGroup[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TaoGroup|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
