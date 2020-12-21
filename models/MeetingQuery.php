<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Meeting]].
 *
 * @see Meeting
 */
class MeetingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Meeting[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Meeting|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
