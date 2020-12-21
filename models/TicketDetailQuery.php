<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TicketDetail]].
 *
 * @see TicketDetail
 */
class TicketDetailQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TicketDetail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TicketDetail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
