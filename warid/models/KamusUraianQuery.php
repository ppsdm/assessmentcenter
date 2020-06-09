<?php

namespace warid\models;

/**
 * This is the ActiveQuery class for [[KamusUraian]].
 *
 * @see KamusUraian
 */
class KamusUraianQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return KamusUraian[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return KamusUraian|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
