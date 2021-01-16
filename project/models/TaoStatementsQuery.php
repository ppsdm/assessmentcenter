<?php

namespace project\models;

/**
 * This is the ActiveQuery class for [[TaoStatements]].
 *
 * @see TaoStatements
 */
class TaoStatementsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TaoStatements[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TaoStatements|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
