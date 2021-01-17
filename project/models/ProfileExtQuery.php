<?php

namespace project\models;

/**
 * This is the ActiveQuery class for [[ProfileExt]].
 *
 * @see ProfileExt
 */
class ProfileExtQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProfileExt[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProfileExt|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
