<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[Videochat]].
 *
 * @see Videochat
 */
class VideochatQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Videochat[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Videochat|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
