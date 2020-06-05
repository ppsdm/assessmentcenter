<?php

namespace warid\models;

/**
 * This is the ActiveQuery class for [[TaoDelivery]].
 *
 * @see TaoDelivery
 */
class TaoDeliveryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TaoDelivery[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TaoDelivery|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
