<?php

namespace project\models;

/**
 * This is the ActiveQuery class for [[ProfileContact]].
 *
 * @see ProfileContact
 */
class ProfileContactQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProfileContact[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProfileContact|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
