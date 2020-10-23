<?php

namespace project\models;

/**
 * This is the ActiveQuery class for [[TaoUser]].
 *
 * @see TaoUser
 */
class TaoUserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TaoUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TaoUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
